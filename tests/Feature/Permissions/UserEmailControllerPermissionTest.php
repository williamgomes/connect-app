<?php

namespace Tests\Feature\Permissions;

use App\Models\User;
use App\Models\UserEmail;
use Tests\TestCase;

class UserEmailControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $user = User::inRandomOrder()->first();
        $userEmail = UserEmail::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\UserEmailController@index', $user))->assertStatus(200);
        $this->get(action('App\UserEmailController@show', [$user, $userEmail]))->assertStatus(200);
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $user = User::inRandomOrder()->first();
        $userEmail = UserEmail::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\UserEmailController@index', $user))->assertStatus(200);
        $this->get(action('App\UserEmailController@show', [$user, $userEmail]))->assertStatus(200);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $user = User::inRandomOrder()->first();
        $userEmail = UserEmail::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\UserEmailController@index', $user))->assertStatus(403);
        $this->get(action('App\UserEmailController@show', [$user, $userEmail]))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $user = User::inRandomOrder()->first();
        $userEmail = UserEmail::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\UserEmailController@index', $user))->assertStatus(403);
        $this->get(action('App\UserEmailController@show', [$user, $userEmail]))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $user = User::inRandomOrder()->first();
        $userEmail = UserEmail::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\UserEmailController@index', $user))->assertStatus(403);
        $this->get(action('App\UserEmailController@show', [$user, $userEmail]))->assertStatus(403);
    }
}
