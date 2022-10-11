<?php

namespace Tests\Feature\Permissions;

use App\Models\Application;
use App\Models\User;
use Tests\TestCase;

class ApplicationControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $application = Application::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ApplicationController@index'))->assertStatus(200);
        $this->get(action('App\ApplicationController@create'))->assertStatus(200);
        $applicationData = Application::factory()->make()->toArray();
        $this->post(action('App\ApplicationController@store'), $applicationData)->assertRedirectContains(action('App\ApplicationController@index'));
        $this->get(action('App\ApplicationController@edit', $application))->assertStatus(200);
        $this->post(action('App\ApplicationController@update', $application))->assertValid()->assertRedirect(action('App\ApplicationController@index'));
        $this->delete(action('App\ApplicationController@destroy', $application))->assertRedirect(action('App\ApplicationController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $application = Application::inRandomOrder()->first();

        $this->actingAs($agent);
        $this->get(action('App\ApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApplicationController@create'))->assertStatus(403);
        $applicationData = Application::factory()->make()->toArray();
        $this->post(action('App\ApplicationController@store'), $applicationData)->assertStatus(403);
        $this->get(action('App\ApplicationController@edit', $application))->assertStatus(403);
        $this->post(action('App\ApplicationController@update', $application))->assertStatus(403);
        $this->delete(action('App\ApplicationController@destroy', $application))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $application = Application::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApplicationController@create'))->assertStatus(403);
        $applicationData = Application::factory()->make()->toArray();
        $this->post(action('App\ApplicationController@store'), $applicationData)->assertStatus(403);
        $this->get(action('App\ApplicationController@edit', $application))->assertStatus(403);
        $this->post(action('App\ApplicationController@update', $application))->assertStatus(403);
        $this->delete(action('App\ApplicationController@destroy', $application))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $application = Application::inRandomOrder()->first();

        $this->actingAs($regularUser);
        $this->get(action('App\ApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApplicationController@create'))->assertStatus(403);
        $applicationData = Application::factory()->make()->toArray();
        $this->post(action('App\ApplicationController@store'), $applicationData)->assertStatus(403);
        $this->get(action('App\ApplicationController@edit', $application))->assertStatus(403);
        $this->post(action('App\ApplicationController@update', $application))->assertStatus(403);
        $this->delete(action('App\ApplicationController@destroy', $application))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $application = Application::inRandomOrder()->first();

        $this->actingAs($developer);
        $this->get(action('App\ApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApplicationController@create'))->assertStatus(403);
        $applicationData = Application::factory()->make()->toArray();
        $this->post(action('App\ApplicationController@store'), $applicationData)->assertStatus(403);
        $this->get(action('App\ApplicationController@edit', $application))->assertStatus(403);
        $this->post(action('App\ApplicationController@update', $application))->assertStatus(403);
        $this->delete(action('App\ApplicationController@destroy', $application))->assertStatus(403);
    }
}
