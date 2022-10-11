<?php

namespace Tests\Feature\Permissions;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RoleControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\RoleController@index'))->assertStatus(200);
        $this->get(action('App\RoleController@create'))->assertStatus(200);

        $roleData = Role::factory()->make()->toArray();
        $this->post(action('App\RoleController@store'), $roleData)->assertValid()->assertRedirect(action('App\RoleController@index'));
        $this->get(action('App\RoleController@edit', $role))->assertStatus(200);
        $this->post(action('App\RoleController@update', $role), [])->assertValid()->assertRedirect(action('App\RoleController@index'));
        $this->delete(action('App\RoleController@destroy', $role))->assertRedirect(action('App\RoleController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\RoleController@index'))->assertStatus(403);
        $this->get(action('App\RoleController@create'))->assertStatus(403);

        $roleData = Role::factory()->make()->toArray();
        $this->post(action('App\RoleController@store'), $roleData)->assertValid()->assertStatus(403);
        $this->get(action('App\RoleController@edit', $role))->assertStatus(403);
        $this->post(action('App\RoleController@update', $role))->assertStatus(403);
        $this->delete(action('App\RoleController@destroy', $role))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\RoleController@index'))->assertStatus(403);
        $this->get(action('App\RoleController@create'))->assertStatus(403);

        $roleData = Role::factory()->make()->toArray();
        $this->post(action('App\RoleController@store'), $roleData)->assertValid()->assertStatus(403);
        $this->get(action('App\RoleController@edit', $role))->assertStatus(403);
        $this->post(action('App\RoleController@update', $role))->assertStatus(403);
        $this->delete(action('App\RoleController@destroy', $role))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\RoleController@index'))->assertStatus(403);
        $this->get(action('App\RoleController@create'))->assertStatus(403);

        $roleData = Role::factory()->make()->toArray();
        $this->post(action('App\RoleController@store'), $roleData)->assertValid()->assertStatus(403);
        $this->get(action('App\RoleController@edit', $role))->assertStatus(403);
        $this->post(action('App\RoleController@update', $role))->assertStatus(403);
        $this->delete(action('App\RoleController@destroy', $role))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\RoleController@index'))->assertStatus(403);
        $this->get(action('App\RoleController@create'))->assertStatus(403);

        $roleData = Role::factory()->make()->toArray();
        $this->post(action('App\RoleController@store'), $roleData)->assertValid()->assertStatus(403);
        $this->get(action('App\RoleController@edit', $role))->assertStatus(403);
        $this->post(action('App\RoleController@update', $role))->assertStatus(403);
        $this->delete(action('App\RoleController@destroy', $role))->assertStatus(403);
    }
}
