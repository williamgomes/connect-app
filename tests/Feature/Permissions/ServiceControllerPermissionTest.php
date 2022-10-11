<?php

namespace Tests\Feature\Permissions;

use App\Models\Service;
use App\Models\User;
use Tests\TestCase;

class ServiceControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $service = Service::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ServiceController@index'))->assertStatus(200);
        $this->get(action('App\ServiceController@create'))->assertStatus(200);

        $serviceData = Service::factory()->make()->toArray();
        $this->post(action('App\ServiceController@store'), $serviceData)->assertValid()->assertRedirect(action('App\ServiceController@index'));
        $this->get(action('App\ServiceController@edit', $service))->assertStatus(200);
        $this->post(action('App\ServiceController@update', $service), [])->assertValid()->assertRedirect(action('App\ServiceController@index'));
        $deleteResponse = $this->delete(action('App\ServiceController@destroy', $service));
        if ($service->tickets->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\ServiceController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $service = Service::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ServiceController@index'))->assertStatus(403);
        $this->get(action('App\ServiceController@create'))->assertStatus(403);

        $serviceData = Service::factory()->make()->toArray();
        $this->post(action('App\ServiceController@store'), $serviceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ServiceController@edit', $service))->assertStatus(403);
        $this->post(action('App\ServiceController@update', $service))->assertStatus(403);
        $this->delete(action('App\ServiceController@destroy', $service))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $service = Service::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ServiceController@index'))->assertStatus(403);
        $this->get(action('App\ServiceController@create'))->assertStatus(403);

        $serviceData = Service::factory()->make()->toArray();
        $this->post(action('App\ServiceController@store'), $serviceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ServiceController@edit', $service))->assertStatus(403);
        $this->post(action('App\ServiceController@update', $service))->assertStatus(403);
        $this->delete(action('App\ServiceController@destroy', $service))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $service = Service::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ServiceController@index'))->assertStatus(403);
        $this->get(action('App\ServiceController@create'))->assertStatus(403);

        $serviceData = Service::factory()->make()->toArray();
        $this->post(action('App\ServiceController@store'), $serviceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ServiceController@edit', $service))->assertStatus(403);
        $this->post(action('App\ServiceController@update', $service))->assertStatus(403);
        $this->delete(action('App\ServiceController@destroy', $service))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $service = Service::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ServiceController@index'))->assertStatus(403);
        $this->get(action('App\ServiceController@create'))->assertStatus(403);

        $serviceData = Service::factory()->make()->toArray();
        $this->post(action('App\ServiceController@store'), $serviceData)->assertValid()->assertStatus(403);
        $this->get(action('App\ServiceController@edit', $service))->assertStatus(403);
        $this->post(action('App\ServiceController@update', $service))->assertStatus(403);
        $this->delete(action('App\ServiceController@destroy', $service))->assertStatus(403);
    }
}
