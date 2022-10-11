<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    /**
     * Show user's all emails.
     *
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('viewEmails', $user);

        $emails = $user->emails()->paginate(25);

        return view('app.users.emails.index')->with([
            'user'   => $user,
            'emails' => $emails,
        ]);
    }

    /**
     * Show specific email.
     *
     * @param Request   $request
     * @param User      $user
     * @param UserEmail $userEmail
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user, UserEmail $userEmail)
    {
        $this->authorize('viewEmails', $user);

        return view('app.users.emails.show')->with([
            'user'  => $user,
            'email' => $userEmail,
        ]);
    }
}
