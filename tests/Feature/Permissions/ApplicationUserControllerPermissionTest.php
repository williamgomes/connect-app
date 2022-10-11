<?php

namespace Tests\Feature\Permissions;

use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\User;
use Tests\TestCase;

class ApplicationUserControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $user = User::inRandomOrder()->first();
        $application = Application::inRandomOrder()->first();
        $applicationUser = ApplicationUser::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ApplicationUserController@regeneratePasswordForm', [$applicationUser->user, $applicationUser->application]))->assertStatus(200);
        $this->post(action('App\ApplicationUserController@regeneratePassword', [$applicationUser->user, $applicationUser->application]), [
            'length'          => 30,
            'upper_case'      => true,
            'lower_case'      => false,
            'numbers'         => false,
            'special_symbols' => false,
        ])->assertValid()->assertRedirect(action('App\UserController@show', $applicationUser->user));

        $this->get(action('App\ApplicationUserController@create', $user))->assertStatus(200);
        $this->post(action('App\ApplicationUserController@store', $user), ['application_id' => $application->id])->assertValid()->assertRedirect(action('App\UserController@show', $user));
        $this->delete(action('App\ApplicationUserController@destroy', $applicationUser))->assertRedirect(action('App\UserController@show', $applicationUser->user));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $user = User::inRandomOrder()->first();
        $application = Application::inRandomOrder()->first();
        $applicationUser = ApplicationUser::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ApplicationUserController@regeneratePasswordForm', [$applicationUser->user, $applicationUser->application]))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@regeneratePassword', [$applicationUser->user, $applicationUser->application]), [
            'length'          => 30,
            'upper_case'      => true,
            'lower_case'      => false,
            'numbers'         => false,
            'special_symbols' => false,
        ])->assertStatus(403);

        $this->get(action('App\ApplicationUserController@create', $user))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@store', $user), ['application_id' => $application->id])->assertStatus(403);
        $this->delete(action('App\ApplicationUserController@destroy', $applicationUser))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $user = User::inRandomOrder()->first();
        $application = Application::inRandomOrder()->first();
        $applicationUser = ApplicationUser::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ApplicationUserController@regeneratePasswordForm', [$applicationUser->user, $applicationUser->application]))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@regeneratePassword', [$applicationUser->user, $applicationUser->application]), [
            'length'          => 30,
            'upper_case'      => true,
            'lower_case'      => false,
            'numbers'         => false,
            'special_symbols' => false,
        ])->assertStatus(403);

        $this->get(action('App\ApplicationUserController@create', $user))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@store', $user), ['application_id' => $application->id])->assertStatus(403);
        $this->delete(action('App\ApplicationUserController@destroy', $applicationUser))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $user = User::inRandomOrder()->first();
        $application = Application::inRandomOrder()->first();
        $applicationUser = ApplicationUser::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ApplicationUserController@regeneratePasswordForm', [$applicationUser->user, $applicationUser->application]))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@regeneratePassword', [$applicationUser->user, $applicationUser->application]), [
            'length'          => 30,
            'upper_case'      => true,
            'lower_case'      => false,
            'numbers'         => false,
            'special_symbols' => false,
        ])->assertStatus(403);

        $this->get(action('App\ApplicationUserController@create', $user))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@store', $user), ['application_id' => $application->id])->assertStatus(403);
        $this->delete(action('App\ApplicationUserController@destroy', $applicationUser))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $user = User::inRandomOrder()->first();
        $application = Application::inRandomOrder()->first();
        $applicationUser = ApplicationUser::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ApplicationUserController@regeneratePasswordForm', [$applicationUser->user, $applicationUser->application]))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@regeneratePassword', [$applicationUser->user, $applicationUser->application]), [
            'length'          => 30,
            'upper_case'      => true,
            'lower_case'      => false,
            'numbers'         => false,
            'special_symbols' => false,
        ])->assertStatus(403);

        $this->get(action('App\ApplicationUserController@create', $user))->assertStatus(403);
        $this->post(action('App\ApplicationUserController@store', $user), ['application_id' => $application->id])->assertStatus(403);
        $this->delete(action('App\ApplicationUserController@destroy', $applicationUser))->assertStatus(403);
    }
}
