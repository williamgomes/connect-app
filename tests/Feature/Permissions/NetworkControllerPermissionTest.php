<?php

namespace Tests\Feature\Permissions;

use App\Models\Network;
use App\Models\User;
use Tests\TestCase;

class NetworkControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $network = Network::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\NetworkController@index'))->assertStatus(200);
        $this->get(action('App\NetworkController@create'))->assertStatus(200);
        $networkData = Network::factory()->make()->toArray();
        $this->post(action('App\NetworkController@store'), $networkData)->assertRedirectContains(action('App\NetworkController@index'));
        $this->get(action('App\NetworkController@edit', $network))->assertStatus(200);
        $this->post(action('App\NetworkController@update', $network))->assertValid()->assertRedirect(action('App\NetworkController@index'));
        $this->get(action('App\NetworkController@createIpAddress', $network))->assertStatus(200);
        $this->delete(action('App\NetworkController@destroy', $network))->assertRedirect(action('App\NetworkController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $network = Network::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\NetworkController@index'))->assertStatus(403);
        $this->get(action('App\NetworkController@create'))->assertStatus(403);
        $networkData = Network::factory()->make()->toArray();
        $this->post(action('App\NetworkController@store'), $networkData)->assertStatus(403);
        $this->get(action('App\NetworkController@edit', $network))->assertStatus(403);
        $this->post(action('App\NetworkController@update', $network))->assertStatus(403);
        $this->get(action('App\NetworkController@createIpAddress', $network))->assertStatus(403);
        $this->delete(action('App\NetworkController@destroy', $network))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $network = Network::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\NetworkController@index'))->assertStatus(403);
        $this->get(action('App\NetworkController@create'))->assertStatus(403);
        $networkData = Network::factory()->make()->toArray();
        $this->post(action('App\NetworkController@store'), $networkData)->assertStatus(403);
        $this->get(action('App\NetworkController@edit', $network))->assertStatus(403);
        $this->post(action('App\NetworkController@update', $network))->assertStatus(403);
        $this->get(action('App\NetworkController@createIpAddress', $network))->assertStatus(403);
        $this->delete(action('App\NetworkController@destroy', $network))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $network = Network::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\NetworkController@index'))->assertStatus(403);
        $this->get(action('App\NetworkController@create'))->assertStatus(403);
        $networkData = Network::factory()->make()->toArray();
        $this->post(action('App\NetworkController@store'), $networkData)->assertStatus(403);
        $this->get(action('App\NetworkController@edit', $network))->assertStatus(403);
        $this->post(action('App\NetworkController@update', $network))->assertStatus(403);
        $this->get(action('App\NetworkController@createIpAddress', $network))->assertStatus(403);
        $this->delete(action('App\NetworkController@destroy', $network))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $network = Network::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\NetworkController@index'))->assertStatus(403);
        $this->get(action('App\NetworkController@create'))->assertStatus(403);
        $networkData = Network::factory()->make()->toArray();
        $this->post(action('App\NetworkController@store'), $networkData)->assertStatus(403);
        $this->get(action('App\NetworkController@edit', $network))->assertStatus(403);
        $this->post(action('App\NetworkController@update', $network))->assertStatus(403);
        $this->get(action('App\NetworkController@createIpAddress', $network))->assertStatus(403);
        $this->delete(action('App\NetworkController@destroy', $network))->assertStatus(403);
    }
}
