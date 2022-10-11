<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserEmail;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    /**
     * Show user's all emails.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $this->authorize('viewEmails', $user);

        $emails = $user->emails()->orderBy('created_at', 'DESC')->paginate(25);

        return view('web.emails.index')->with([
            'user'   => $user,
            'emails' => $emails,
        ]);
    }

    /**
     * Show specific email.
     *
     * @param Request   $request
     * @param UserEmail $userEmail
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, UserEmail $userEmail)
    {
        $this->authorize('viewEmails', $userEmail->user);

        $userEmail->update([
            'read' => UserEmail::IS_READ,
        ]);

        return view('web.emails.show')->with([
            'user'  => $userEmail->user,
            'email' => $userEmail,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(Request $request)
    {
        $userEmailIds = $request->input('emails', []);

        foreach ($userEmailIds as $userEmailId) {
            $userEmail = UserEmail::find($userEmailId);

            if ($userEmail) {
                $this->authorize('markAsRead', $userEmail);

                $userEmail->update([
                    'read' => UserEmail::IS_READ,
                ]);
            }
        }

        return redirect()->back()
            ->with('success', __('Emails were successfully marked as read.'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsUnread(Request $request)
    {
        $userEmailIds = $request->input('emails', []);

        foreach ($userEmailIds as $userEmailId) {
            $userEmail = UserEmail::find($userEmailId);

            if ($userEmail) {
                $this->authorize('markAsUnread', $userEmail);

                $userEmail->update([
                    'read' => UserEmail::NOT_READ,
                ]);
            }
        }

        return redirect()->back()
            ->with('success', __('Emails were successfully marked as unread.'));
    }
}
