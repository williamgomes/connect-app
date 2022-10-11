<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Unsubscribe client from newsletters from hash.
     *
     * @param $hash
     *
     * @return $this
     */
    public function unsubscribeBlogFromHash($hash)
    {
        try {
            $userId = decrypt($hash);
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index');
        }

        $user = User::find($userId);
        if ($user) {
            $user->update([
                'blog_notifications' => User::DISABLE_BLOG_NOTIFICATIONS,
            ]);
        }

        return view('web.blog.unsubscribed')->with([
            'user' => $user,
        ]);
    }
}
