<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('app.settings.edit')->with([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $user->update($request->only([
            'blog_notifications',
        ]));

        return redirect()->action('App\SettingsController@update')
            ->with('success', 'Profile settings were successfully updated!');
    }
}
