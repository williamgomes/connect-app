<?php

namespace App\Http\Controllers;

use App\Http\Requests\App\UserVerification\UserVerificationCreateRequest;
use App\Http\Requests\App\UserVerification\UserVerificationUpdateRequest;
use App\Jobs\SendSMS;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVerificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.users.verifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserVerificationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserVerificationCreateRequest $request)
    {
        $user = User::where('synega_id', $request->synega_id)->first();

        if ($user && $user->hasRole(User::ROLE_REGULAR)) {
            $verificationExists = $user->verifications()->where('status', UserVerification::STATUS_INITIATED)->exists();

            if ($verificationExists == false) {
                UserVerification::create([
                    'user_id'    => $user->id,
                    'ip_address' => $request->ip(),
                ]);
            }
        }

        return redirect()->action('UserVerificationController@create')
            ->with('success', __('Please check your email for next steps.'));
    }

    /**
     * Display the specified resource for completion.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $token
     *
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, string $token)
    {
        $userVerification = UserVerification::where('status', UserVerification::STATUS_INITIATED)
            ->where('email_token', $token)
            ->first();

        // Abort on invalid token
        if (is_null($userVerification)) {
            abort(404);
        }

        if ($userVerification->user->phone_number) {
            $body = __('Your Synega code is:') . ' ' . $userVerification->sms_token;
            SendSMS::dispatch($userVerification->user->phone_number, $body);
        }

        return view('web.users.verifications.complete')->with([
            'userVerification' => $userVerification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserVerificationUpdateRequest $request
     * @param string                        $token
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserVerificationUpdateRequest $request, string $token)
    {
        $userVerification = UserVerification::where('status', UserVerification::STATUS_INITIATED)
            ->where('email_token', $token)
            ->first();

        // Abort on invalid token
        if (is_null($userVerification)) {
            abort(404);
        }

        // Successful validation
        if ($userVerification->sms_token == $request->sms_token) {
            Auth::login($userVerification->user);
            $status = UserVerification::STATUS_VERIFIED;
        } else {
            $status = UserVerification::STATUS_FAILED;
        }

        // Update verification status
        $userVerification->update([
            'status' => $status,
        ]);

        return redirect()->action('HomeController@index')
            ->with('success', __("You've now completed the identity validation. Please select what you need help with."));
    }
}
