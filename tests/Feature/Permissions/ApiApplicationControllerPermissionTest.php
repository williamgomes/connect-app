<?php

namespace Tests\Feature\Permissions;

use App\Models\ApiApplication;
use App\Models\User;
use Tests\TestCase;

class ApiApplicationControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ApiApplicationController@index'))->assertStatus(200);
        $this->get(action('App\ApiApplicationController@create'))->assertStatus(200);
        $apiApplicationData = ApiApplication::factory()->make()->toArray();
        $this->post(action('App\ApiApplicationController@store'), $apiApplicationData)->assertRedirectContains(action('App\ApiApplicationController@index'));
        $this->get(action('App\ApiApplicationController@edit', $apiApplication))->assertStatus(200);
        $this->post(action('App\ApiApplicationController@update', $apiApplication))->assertValid()->assertRedirect(action('App\ApiApplicationController@show', $apiApplication));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();

        $this->actingAs($agent);
        $this->get(action('App\ApiApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApiApplicationController@create'))->assertStatus(403);
        $apiApplicationData = ApiApplication::factory()->make()->toArray();
        $this->post(action('App\ApiApplicationController@store'), $apiApplicationData)->assertStatus(403);
        $this->get(action('App\ApiApplicationController@edit', $apiApplication))->assertStatus(403);
        $this->post(action('App\ApiApplicationController@update', $apiApplication))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ApiApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApiApplicationController@create'))->assertStatus(403);
        $apiApplicationData = ApiApplication::factory()->make()->toArray();
        $this->post(action('App\ApiApplicationController@store'), $apiApplicationData)->assertStatus(403);
        $this->get(action('App\ApiApplicationController@edit', $apiApplication))->assertStatus(403);
        $this->post(action('App\ApiApplicationController@update', $apiApplication))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();

        $this->actingAs($regularUser);
        $this->get(action('App\ApiApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApiApplicationController@create'))->assertStatus(403);
        $apiApplicationData = ApiApplication::factory()->make()->toArray();
        $this->post(action('App\ApiApplicationController@store'), $apiApplicationData)->assertStatus(403);
        $this->get(action('App\ApiApplicationController@edit', $apiApplication))->assertStatus(403);
        $this->post(action('App\ApiApplicationController@update', $apiApplication))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();

        $this->actingAs($developer);
        $this->get(action('App\ApiApplicationController@index'))->assertStatus(403);
        $this->get(action('App\ApiApplicationController@create'))->assertStatus(403);
        $apiApplicationData = ApiApplication::factory()->make()->toArray();
        $this->post(action('App\ApiApplicationController@store'), $apiApplicationData)->assertStatus(403);
        $this->get(action('App\ApiApplicationController@edit', $apiApplication))->assertStatus(403);
        $this->post(action('App\ApiApplicationController@update', $apiApplication))->assertStatus(403);
    }
}
