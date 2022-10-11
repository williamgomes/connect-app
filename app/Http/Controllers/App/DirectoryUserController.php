<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\DirectoryUser;
use Illuminate\Http\Request;

class DirectoryUserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DirectoryUser $directoryUser
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(DirectoryUser $directoryUser)
    {
        $this->authorize('update', $directoryUser);

        return view('app.users.directories.edit')->with([
            'directoryUser' => $directoryUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request       $request
     * @param DirectoryUser $directoryUser
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DirectoryUser $directoryUser)
    {
        $this->authorize('update', $directoryUser);

        $directoryUser->update($request->only([
            'username',
        ]));

        return redirect()->action('App\UserController@show', $directoryUser->user)
            ->with('success', __('The Directory was successfully updated.'));
    }
}
