<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UserCreateRequest;
use App\Http\Requests\Api\v1\User\UserIndexRequest;
use App\Http\Requests\Api\v1\User\UserUpdateRequest;
use App\Http\Resources\Api\v1\User as UserResource;
use App\Lib\ApiApplicationAccess\Facades\ApiApplicationAccess;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserIndexRequest $request)
    {
        $usersQuery = User::query();

        if ($request->has('synega_id')) {
            $usersQuery->where('synega_id', $request->input('synega_id'));
        }

        if ($request->has('first_name')) {
            $usersQuery->where('first_name', $request->input('first_name'));
        }

        if ($request->has('last_name')) {
            $usersQuery->where('last_name', $request->input('last_name'));
        }

        if ($request->has('default_username')) {
            $usersQuery->where('default_username', $request->input('default_username'));
        }

        if ($request->has('email')) {
            $usersQuery->where('email', $request->input('email'));
        }

        if ($request->has('phone_number')) {
            $usersQuery->where('phone_number', $request->input('phone_number'));
        }

        return UserResource::collection($usersQuery->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     *
     * @return UserResource
     */
    public function store(UserCreateRequest $request)
    {
        // Authorize request
        ApiApplicationAccess::authorize('create', User::class);

        $user = User::create($request->only([
            'synega_id',
            'onelogin_id',
            'duo_id',
            'first_name',
            'last_name',
            'default_username',
            'email',
            'phone_number',
            'role',
            'slack_webhook_url',
            'active',
            'blog_notifications',
        ]));

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return UserResource
     */
    public function show(Request $request, User $user)
    {
        // Authorize request
        ApiApplicationAccess::authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User              $user
     *
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        // Authorize request
        ApiApplicationAccess::authorize('update', $user);

        $user = $user->update($request->only([
            'synega_id',
            'onelogin_id',
            'duo_id',
            'first_name',
            'last_name',
            'default_username',
            'email',
            'phone_number',
            'role',
            'slack_webhook_url',
            'active',
            'blog_notifications',
        ]));

        return new UserResource($user);
    }
}
