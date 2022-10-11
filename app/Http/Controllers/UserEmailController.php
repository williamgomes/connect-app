<?php

namespace App\Http\Controllers;

use App\Helpers\EmailParseHelper;
use App\Models\Company;
use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserEmailController extends Controller
{
    /**
     * @param Request $request
     * @param Company $company
     *
     * @throws FileNotFoundException
     * @throws BindingResolutionException
     *
     * @return string
     */
    public function processIncomingEmail(Request $request, Company $company)
    {
        if (!env('SNS_SUBSCRIBED', true)) {
            $payload = json_decode($request->getContent(), true);
            // Activate SNS
            if (!empty($payload['SubscribeURL'])) {
                curl_exec(curl_init($payload['SubscribeURL']));

                return '';
            }

            abort(404);
        }

        $emailDomain = env('EMAIL_DOMAIN');

        $messageBody = json_decode($request->getContent());
        $message = json_decode($messageBody->Message);
        $messageId = $message->mail->messageId;

        // Check if email has been imported before
        $existingEmail = UserEmail::where('message_id', $messageId)->exists();

        // Create the email if not found
        if ($existingEmail == false) {
            // Get raw email content
            $rawEmailContent = Storage::disk('s3-sns')->get($messageId);

            $parser = new EmailParseHelper();
            $incomingEmail = $parser->parse($rawEmailContent);

            $from = $incomingEmail['from'][0];
            $toEmail = $incomingEmail['to'][0]['address'] ?? '';

            $identifier = strtolower(str_replace('@' . $emailDomain, '', $toEmail));

            $user = User::where('id', $identifier)->orWhere('default_username', $identifier)->first();

            // All links should open in new tab
            $body = str_replace('<a ', '<a target="_blank"', $incomingEmail['html_body'] ?? $incomingEmail['text_body']);

            if ($user) {
                // Store user email
                UserEmail::create([
                    'user_id'    => $user->id,
                    'company_id' => $company->id,
                    'message_id' => $messageId,
                    'from_name'  => $from['display'],
                    'from'       => $from['address'],
                    'to'         => $toEmail,
                    'subject'    => $incomingEmail['subject'],
                    'body'       => $body,
                ]);
            }

            return '';
        }
    }
}
