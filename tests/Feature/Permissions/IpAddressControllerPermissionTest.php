<?php

namespace Tests\Feature\Permissions;

use App\Models\IpAddress;
use App\Models\Network;
use App\Models\User;
use Tests\TestCase;

class IpAddressControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $ipAddress = IpAddress::inRandomOrder()->first();

        $this->actingAs($admin);

        $ipAddressData = IpAddress::factory()->make()->toArray();
        $network = Network::find($ipAddressData['network_id']);
        $this->post(action('App\IpAddressController@store'), $ipAddressData)->assertRedirectContains(action('App\NetworkController@show', $network));
        $this->get(action('App\IpAddressController@edit', $ipAddress))->assertStatus(200);
        $this->post(action('App\IpAddressController@update', $ipAddress))->assertValid()->assertRedirect(action('App\NetworkController@show', $ipAddress->network));
        $this->delete(action('App\IpAddressController@destroy', $ipAddress))->assertRedirect(action('App\NetworkController@show', $ipAddress->network));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $ipAddress = IpAddress::inRandomOrder()->first();

        $this->actingAs($agent);

        $ipAddressData = IpAddress::factory()->make()->toArray();
        $this->post(action('App\IpAddressController@store'), $ipAddressData)->assertStatus(403);
        $this->get(action('App\IpAddressController@edit', $ipAddress))->assertStatus(403);
        $this->post(action('App\IpAddressController@update', $ipAddress))->assertStatus(403);
        $this->delete(action('App\IpAddressController@destroy', $ipAddress))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $ipAddress = IpAddress::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $ipAddressData = IpAddress::factory()->make()->toArray();
        $this->post(action('App\IpAddressController@store'), $ipAddressData)->assertStatus(403);
        $this->get(action('App\IpAddressController@edit', $ipAddress))->assertStatus(403);
        $this->post(action('App\IpAddressController@update', $ipAddress))->assertStatus(403);
        $this->delete(action('App\IpAddressController@destroy', $ipAddress))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $ipAddress = IpAddress::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $ipAddressData = IpAddress::factory()->make()->toArray();
        $this->post(action('App\IpAddressController@store'), $ipAddressData)->assertStatus(403);
        $this->get(action('App\IpAddressController@edit', $ipAddress))->assertStatus(403);
        $this->post(action('App\IpAddressController@update', $ipAddress))->assertStatus(403);
        $this->delete(action('App\IpAddressController@destroy', $ipAddress))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $ipAddress = IpAddress::inRandomOrder()->first();

        $this->actingAs($developer);

        $ipAddressData = IpAddress::factory()->make()->toArray();
        $this->post(action('App\IpAddressController@store'), $ipAddressData)->assertStatus(403);
        $this->get(action('App\IpAddressController@edit', $ipAddress))->assertStatus(403);
        $this->post(action('App\IpAddressController@update', $ipAddress))->assertStatus(403);
        $this->delete(action('App\IpAddressController@destroy', $ipAddress))->assertStatus(403);
    }
}
