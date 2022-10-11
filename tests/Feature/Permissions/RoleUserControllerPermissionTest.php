<?php

namespace Tests\Feature\Permissions;

use App\Models\RoleUser;
use App\Models\User;
use Tests\TestCase;

class RoleUserControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $roleUser = RoleUser::inRandomOrder()->first();

        $this->actingAs($admin);

        $roleUserData = $this->fakeRoleUserData();

        $user = User::find($roleUserData['user_id']);

        $this->get(action('App\RoleUserController@create', $user))->assertStatus(200);
        $this->post(action('App\RoleUserController@store', $user), $roleUserData)->assertValid()->assertRedirect(action('App\UserController@show', $user));
        $this->delete(action('App\RoleUserController@destroy', $roleUser))->assertRedirect(action('App\UserController@show', $roleUser->user));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $roleUser = RoleUser::inRandomOrder()->first();

        $this->actingAs($agent);

        $roleUserData = $this->fakeRoleUserData();

        $user = User::find($roleUserData['user_id']);

        $this->get(action('App\RoleUserController@create', $user))->assertStatus(200);
        $this->post(action('App\RoleUserController@store', $user), $roleUserData)->assertValid()->assertRedirect(action('App\UserController@show', $user));
        $this->delete(action('App\RoleUserController@destroy', $roleUser))->assertRedirect(action('App\UserController@show', $roleUser->user));
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $roleUser = RoleUser::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $roleUserData = $this->fakeRoleUserData();

        $user = User::find($roleUserData['user_id']);

        $this->get(action('App\RoleUserController@create', $user))->assertStatus(403);
        $this->post(action('App\RoleUserController@store', $user), $roleUserData)->assertStatus(403);
        $this->delete(action('App\RoleUserController@destroy', $roleUser))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $roleUser = RoleUser::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $roleUserData = $this->fakeRoleUserData();

        $user = User::find($roleUserData['user_id']);

        $this->get(action('App\RoleUserController@create', $user))->assertStatus(403);
        $this->post(action('App\RoleUserController@store', $user), $roleUserData)->assertStatus(403);
        $this->delete(action('App\RoleUserController@destroy', $roleUser))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $roleUser = RoleUser::inRandomOrder()->first();

        $this->actingAs($developer);

        $roleUserData = $this->fakeRoleUserData();

        $user = User::find($roleUserData['user_id']);

        $this->get(action('App\RoleUserController@create', $user))->assertStatus(403);
        $this->post(action('App\RoleUserController@store', $user), $roleUserData)->assertStatus(403);
        $this->delete(action('App\RoleUserController@destroy', $roleUser))->assertStatus(403);
    }
}
