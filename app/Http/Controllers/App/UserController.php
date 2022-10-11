<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\User\UserCreateRequest;
use App\Http\Requests\App\User\UserUpdateProfilePictureRequest;
use App\Http\Requests\App\User\UserUpdateRequest;
use App\Models\ApplicationUser;
use App\Models\Permission;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->search;

        $userQuery = User::query();

        if ($request->has('search')) {
            $userQuery->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('default_username', 'LIKE', '%' . $search . '%')
                ->orWhere('synega_id', 'LIKE', '%' . $search . '%')
                ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                ->orWhereHas('directoryUsers', function ($query) use ($search) {
                    $query->where('onelogin_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('duo_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('username', 'LIKE', '%' . $search . '%');
                });
        }

        return view('app.users.index')->with([
            'users' => $userQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('app.users.create')->with([
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $this->authorize('create', User::class);

        $user = User::create(array_merge([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => '+' . $request->phone_number,
        ], [
            'x_data' => $request->only('permissions'),
        ]));

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('User was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $applicationUsers = ApplicationUser::where('application_user.user_id', $user->id)
            ->where('application_user.active', ApplicationUser::IS_ACTIVE)
            ->where(function ($query) {
                $query->where('application_user.direct', ApplicationUser::IS_DIRECT)
                    ->orWhere(function ($query) {
                        $query->where('application_user.direct', ApplicationUser::NOT_DIRECT)
                            ->whereNotExists(function ($query) {
                                $query->select(DB::raw(1))
                                    ->from('application_user as au')
                                    ->whereRaw('application_user.user_id = au.user_id')
                                    ->whereRaw('application_user.application_id = au.application_id')
                                    ->where('au.direct', ApplicationUser::IS_DIRECT)
                                    ->where('au.active', ApplicationUser::IS_ACTIVE);
                            });
                    });
            })
            ->get();

        $roleUsers = $user->roleUsers()
            ->orderBy('company_id')
            ->get();

        return view('app.users.show')->with([
            'user'             => $user,
            'applicationUsers' => $applicationUsers,
            'roleUsers'        => $roleUsers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('app.users.edit')->with([
            'user'        => $user,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param \App\Models\User  $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_merge($request->only([
            'active',
            'first_name',
            'last_name',
            'default_username',
            'email',
            'phone_number',
            'role',
            'slack_webhook_url',
            'blog_notifications',
        ]), [
            'x_data' => [
                'permissions' => $request->input('permissions', []),
            ],
        ]));

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('The user was successfully updated.'));
    }

    /**
     * Activate the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(User $user)
    {
        $this->authorize('update', $user);

        $user->update([
            'active' => User::IS_ACTIVE,
        ]);

        return redirect()->action('App\UserController@index')
            ->with('success', __('The user was successfully activated.'));
    }

    /**
     * Deactivate the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(User $user)
    {
        $this->authorize('update', $user);

        if (!$user->hasRole(User::ROLE_ADMIN)) {
            $user->update([
                'active' => User::NOT_ACTIVE,
            ]);
        }

        return redirect()->action('App\UserController@index')
            ->with('success', __('The user was successfully deactivated.'));
    }

    /**
     * Update profile picture from settings or user edit page.
     *
     * @param UserUpdateProfilePictureRequest $request
     * @param User                            $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfilePicture(UserUpdateProfilePictureRequest $request, User $user)
    {
        if ($user->profile_picture != 'default.png') {
            // Delete old picture
            Storage::disk('s3')->delete('images/profile/' . $user->profile_picture);
        }

        $profilePicture = $request->file('profile_picture');

        // Crop new picture
        Image::make($profilePicture)
            ->crop($request->input('crop_width'), $request->input('crop_height'), $request->input('crop_x'), $request->input('crop_y'))
            ->save($profilePicture->getPathName());

        // Store new picture
        $profilePicturePath = $profilePicture->store('images/profile', 's3');

        $user->update([
            'profile_picture' => basename($profilePicturePath),
        ]);

        return redirect()->back()
            ->with('success', __('Profile picture successfully updated.'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function tickets(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $ticketQuery = $user->tickets();

        $ticketQuery->where('status', $request->input('status', Ticket::STATUS_OPEN));

        // Handle any search present
        if ($request->filled('search')) {
            $search = $request->input('search');
            $ticketQuery->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('title', 'LIKE', '%' . $search . '%');
            });
        }

        // Order by updated_at
        $tickets = $ticketQuery->orderBy('updated_at', 'DESC')->paginate(25);

        return view('app.users.tickets.index')->with([
            'user'    => $user,
            'tickets' => $tickets,
        ]);
    }
}
