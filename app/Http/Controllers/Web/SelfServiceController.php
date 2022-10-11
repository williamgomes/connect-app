<?php

namespace App\Http\Controllers\Web;

use App\Helpers\DuoSecurity;
use App\Helpers\OneLoginHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Duo\SendDuoEnrollmentEmail;
use App\Jobs\SendSMS;
use App\Models\Directory;
use App\Models\DirectoryUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SelfServiceController extends Controller
{
    /**
     * Create a new password for the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPassword(Request $request)
    {
        return view('web.self-service.password');
    }

    /**
     * Store a new password for the logged in user.
     *
     * @throws \Illuminate\Http\Client\RequestException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePassword(Request $request)
    {
        $request->validate([
            'directory_id' => [
                'required',
                'integer',
                Rule::exists('directory_user', 'directory_id')->where(function ($query) {
                    $query->where('user_id', request()->user()->id);
                }),
            ],
            'password'     => [
                'required',
                'string',
                'min:12',
                'max:64',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).*$/',
                'confirmed',
            ],
        ]);

        // Get logged in user
        $user = $request->user();
        $directory = Directory::find($request->input('directory_id'));

        $oneLoginClient = new OneLoginHelper();
        $token = $oneLoginClient->generateToken($directory);

        $response = Http::log()->withToken($token)
            ->get($directory->onelogin_api_url . '/api/2/users', [
                'username' => $user->synega_id,
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        $oneLoginUserId = $response[0]['id'] ?? null;
        if (is_null($oneLoginUserId)) {
            return redirect()->back()
                ->with('error', __('We failed to find your User ID. Please report this problem to the Connect Team.'));
        }

        // Set password with salt
        $salt = Str::random(10);
        $password = hash('sha256', $salt . $request->password);

        $response = Http::log()->withToken($token)
            ->put($directory->onelogin_api_url . '/api/2/users/' . $oneLoginUserId, [
                'password'              => $password,
                'password_confirmation' => $password,
                'password_algorithm'    => 'salt+sha256',
                'salt'                  => $salt,
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        return redirect()->action('Web\HelpCenterController@index')
            ->with('success', __("You're password has successfully been updated."));
    }

    /**
     * Create a new passcode for the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPasscode(Request $request)
    {
        return view('web.self-service.passcode');
    }

    /**
     * Store a new passcode for the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePasscode(Request $request)
    {
        $request->validate([
            'directory_id' => [
                'required',
                'integer',
                Rule::exists('directory_user', 'directory_id')->where(function ($query) {
                    $query->where('user_id', request()->user()->id);
                }),
            ],
            'hours'        => 'required|integer|min:1|max:48',
            'confirmation' => 'required|string|in:YES',
        ]);

        // Get logged in user
        $user = $request->user();
        $directory = Directory::find($request->input('directory_id'));

        $duoClient = new DuoSecurity\Client(
            $directory->duo_integration_key,
            $directory->duo_secret_key,
            $directory->duo_api_url,
        );

        $response = $duoClient->jsonApiCall('GET', '/admin/v1/users', [
            'username' => $user->synega_id,
        ]);

        $duoUserId = $response['response']['response'][0]['user_id'] ?? null;
        if (is_null($duoUserId)) {
            return redirect()->back()
                ->with('error', __('We failed to find your User ID. Please report this problem to the Connect Team.'));
        }

        $response = $duoClient->jsonApiCall('POST', '/admin/v1/users/' . $duoUserId . '/bypass_codes', [
            'count'       => 1,
            'reuse_count' => 0,
            'valid_secs'  => $request->hours * 60 * 60,
        ]);

        $buypassCode = $response['response']['response'][0] ?? null;
        if ($user->phone_number && $buypassCode) {
            $body = __('Your temporary DUO Mobile code is:') . ' ' . $buypassCode;
            SendSMS::dispatch($user->phone_number, $body);
        }

        return redirect()->action('Web\HelpCenterController@index')
            ->with('success', __('The passcode has now been sent to your mobile phone via SMS.'));
    }

    /**
     * Create a new phone for the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPhone(Request $request)
    {
        return view('web.self-service.phone');
    }

    /**
     * Store a new phone for the logged in user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhone(Request $request)
    {
        $request->validate([
            'directory_id' => [
                'required',
                'integer',
                Rule::exists('directory_user', 'directory_id')->where(function ($query) {
                    $query->where('user_id', request()->user()->id);
                }),
            ],
            'confirmation' => 'required|string|in:YES',
        ]);

        // Get logged in user
        $user = $request->user();
        $directory = Directory::find($request->input('directory_id'));

        $duoClient = new DuoSecurity\Client(
            $directory->duo_integration_key,
            $directory->duo_secret_key,
            $directory->duo_api_url,
        );

        $response = $duoClient->jsonApiCall('GET', '/admin/v1/users', [
            'username' => $user->synega_id,
        ]);

        $duoUserId = $response['response']['response'][0]['user_id'] ?? null;
        if (is_null($duoUserId)) {
            return redirect()->back()
                ->with('error', __('We failed to find your User ID. Please report this problem to the Connect Team.'));
        }

        $response = $duoClient->jsonApiCall('GET', '/admin/v1/users/' . $duoUserId . '/phones', [
            'limit'  => 100,
            'offset' => 0,
        ]);

        // Remove all phones from the user and delete the phone
        $phones = $response['response']['response'] ?? [];
        foreach ($phones as $phone) {
            $duoClient->jsonApiCall('DELETE', '/admin/v1/users/' . $duoUserId . '/phones/' . $phone['phone_id'], []);
            $duoClient->jsonApiCall('DELETE', '/admin/v1/phones/' . $phone['phone_id'], []);
        }

        $directoryUser = DirectoryUser::where('directory_id', $directory->id)
            ->where('user_id', $user->id)
            ->first();

        // Re-send enrollment email from DUO Mobile
        SendDuoEnrollmentEmail::dispatch($directoryUser)->delay(now()->addMinutes(1));

        return redirect()->action('Web\HelpCenterController@index')
            ->with('success', __('The DUO Mobile setup guide has now been sent to your email address. This might take a minute or two.'));
    }
}
