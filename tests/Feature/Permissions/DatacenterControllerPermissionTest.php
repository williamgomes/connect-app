<?php

namespace Tests\Feature\Permissions;

use App\Models\Datacenter;
use App\Models\User;
use Tests\TestCase;

class DatacenterControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $datacenter = Datacenter::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\DatacenterController@index'))->assertStatus(200);
        $this->get(action('App\DatacenterController@create'))->assertStatus(200);

        $datacenterData = Datacenter::factory()->make()->toArray();
        $this->post(action('App\DatacenterController@store'), $datacenterData)->assertValid()->assertRedirect(action('App\DatacenterController@index'));
        $this->get(action('App\DatacenterController@edit', $datacenter))->assertStatus(200);
        $this->post(action('App\DatacenterController@update', $datacenter), [])->assertValid()->assertRedirect(action('App\DatacenterController@index'));
        $this->delete(action('App\DatacenterController@destroy', $datacenter))->assertRedirect(action('App\DatacenterController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $datacenter = Datacenter::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\DatacenterController@index'))->assertStatus(403);
        $this->get(action('App\DatacenterController@create'))->assertStatus(403);

        $datacenterData = Datacenter::factory()->make()->toArray();
        $this->post(action('App\DatacenterController@store'), $datacenterData)->assertValid()->assertStatus(403);
        $this->get(action('App\DatacenterController@edit', $datacenter))->assertStatus(403);
        $this->post(action('App\DatacenterController@update', $datacenter))->assertStatus(403);
        $this->delete(action('App\DatacenterController@destroy', $datacenter))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $datacenter = Datacenter::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\DatacenterController@index'))->assertStatus(403);
        $this->get(action('App\DatacenterController@create'))->assertStatus(403);

        $datacenterData = Datacenter::factory()->make()->toArray();
        $this->post(action('App\DatacenterController@store'), $datacenterData)->assertValid()->assertStatus(403);
        $this->get(action('App\DatacenterController@edit', $datacenter))->assertStatus(403);
        $this->post(action('App\DatacenterController@update', $datacenter))->assertStatus(403);
        $this->delete(action('App\DatacenterController@destroy', $datacenter))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $datacenter = Datacenter::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\DatacenterController@index'))->assertStatus(403);
        $this->get(action('App\DatacenterController@create'))->assertStatus(403);

        $datacenterData = Datacenter::factory()->make()->toArray();
        $this->post(action('App\DatacenterController@store'), $datacenterData)->assertValid()->assertStatus(403);
        $this->get(action('App\DatacenterController@edit', $datacenter))->assertStatus(403);
        $this->post(action('App\DatacenterController@update', $datacenter))->assertStatus(403);
        $this->delete(action('App\DatacenterController@destroy', $datacenter))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $datacenter = Datacenter::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\DatacenterController@index'))->assertStatus(403);
        $this->get(action('App\DatacenterController@create'))->assertStatus(403);

        $datacenterData = Datacenter::factory()->make()->toArray();
        $this->post(action('App\DatacenterController@store'), $datacenterData)->assertValid()->assertStatus(403);
        $this->get(action('App\DatacenterController@edit', $datacenter))->assertStatus(403);
        $this->post(action('App\DatacenterController@update', $datacenter))->assertStatus(403);
        $this->delete(action('App\DatacenterController@destroy', $datacenter))->assertStatus(403);
    }
}
