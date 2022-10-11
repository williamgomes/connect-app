<?php

namespace Tests\Feature\Permissions;

use App\Models\ItService;
use App\Models\User;
use Tests\TestCase;

class ItServiceControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $itService = ItService::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ItServiceController@index'))->assertStatus(200);
        $this->get(action('App\ItServiceController@create'))->assertStatus(200);

        $itServiceData = ItService::factory()->make()->toArray();
        $this->post(action('App\ItServiceController@store'), $itServiceData)->assertValid()->assertRedirect(action('App\ItServiceController@index'));
        $this->get(action('App\ItServiceController@edit', $itService))->assertStatus(200);
        $this->post(action('App\ItServiceController@update', $itService), [])->assertValid()->assertRedirect(action('App\ItServiceController@index'));
        $this->delete(action('App\ItServiceController@destroy', $itService))->assertRedirect(action('App\ItServiceController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $itService = ItService::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ItServiceController@index'))->assertStatus(403);
        $this->get(action('App\ItServiceController@create'))->assertStatus(403);

        $itServiceData = ItService::factory()->make()->toArray();
        $this->post(action('App\ItServiceController@store'), $itServiceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ItServiceController@edit', $itService))->assertStatus(403);
        $this->post(action('App\ItServiceController@update', $itService))->assertStatus(403);
        $this->delete(action('App\ItServiceController@destroy', $itService))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $itService = ItService::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ItServiceController@index'))->assertStatus(403);
        $this->get(action('App\ItServiceController@create'))->assertStatus(403);

        $itServiceData = ItService::factory()->make()->toArray();
        $this->post(action('App\ItServiceController@store'), $itServiceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ItServiceController@edit', $itService))->assertStatus(403);
        $this->post(action('App\ItServiceController@update', $itService))->assertStatus(403);
        $this->delete(action('App\ItServiceController@destroy', $itService))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $itService = ItService::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ItServiceController@index'))->assertStatus(403);
        $this->get(action('App\ItServiceController@create'))->assertStatus(403);

        $itServiceData = ItService::factory()->make()->toArray();
        $this->post(action('App\ItServiceController@store'), $itServiceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ItServiceController@edit', $itService))->assertStatus(403);
        $this->post(action('App\ItServiceController@update', $itService))->assertStatus(403);
        $this->delete(action('App\ItServiceController@destroy', $itService))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $itService = ItService::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ItServiceController@index'))->assertStatus(403);
        $this->get(action('App\ItServiceController@create'))->assertStatus(403);

        $itServiceData = ItService::factory()->make()->toArray();
        $this->post(action('App\ItServiceController@store'), $itServiceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ItServiceController@edit', $itService))->assertStatus(403);
        $this->post(action('App\ItServiceController@update', $itService))->assertStatus(403);
        $this->delete(action('App\ItServiceController@destroy', $itService))->assertStatus(403);
    }
}
