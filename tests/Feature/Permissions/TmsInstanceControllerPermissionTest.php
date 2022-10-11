<?php

namespace Tests\Feature\Permissions;

use App\Models\TmsInstance;
use App\Models\User;
use Tests\TestCase;

class TmsInstanceControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $tmsInstance = TmsInstance::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\TmsInstanceController@index'))->assertStatus(200);
        $this->get(action('App\TmsInstanceController@create'))->assertStatus(200);
        $tmsInstanceData = TmsInstance::factory()->make()->toArray();
        $this->post(action('App\TmsInstanceController@store'), $tmsInstanceData)->assertRedirectContains(action('App\TmsInstanceController@index'));
        $this->get(action('App\TmsInstanceController@edit', $tmsInstance))->assertStatus(200);
        $this->post(action('App\TmsInstanceController@update', $tmsInstance), [])->assertValid()->assertRedirect(action('App\TmsInstanceController@index'));
        $delete = $this->delete(action('App\TmsInstanceController@destroy', $tmsInstance));
        if ($tmsInstance->companies()->count()) {
            $delete->assertStatus(403);
        } else {
            $delete->assertRedirect(action('App\TmsInstanceController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $tmsInstance = TmsInstance::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\TmsInstanceController@index'))->assertStatus(403);
        $this->get(action('App\TmsInstanceController@create'))->assertStatus(403);
        $tmsInstanceData = TmsInstance::factory()->make()->toArray();
        $this->post(action('App\TmsInstanceController@store'), $tmsInstanceData)->assertStatus(403);
        $this->get(action('App\TmsInstanceController@edit', $tmsInstance))->assertStatus(403);
        $this->post(action('App\TmsInstanceController@update', $tmsInstance), [])->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $tmsInstance = TmsInstance::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\TmsInstanceController@index'))->assertStatus(403);
        $this->get(action('App\TmsInstanceController@create'))->assertStatus(403);
        $tmsInstanceData = TmsInstance::factory()->make()->toArray();
        $this->post(action('App\TmsInstanceController@store'), $tmsInstanceData)->assertStatus(403);
        $this->get(action('App\TmsInstanceController@edit', $tmsInstance))->assertStatus(403);
        $this->post(action('App\TmsInstanceController@update', $tmsInstance), [])->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $tmsInstance = TmsInstance::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\TmsInstanceController@index'))->assertStatus(403);
        $this->get(action('App\TmsInstanceController@create'))->assertStatus(403);
        $tmsInstanceData = TmsInstance::factory()->make()->toArray();
        $this->post(action('App\TmsInstanceController@store'), $tmsInstanceData)->assertStatus(403);
        $this->get(action('App\TmsInstanceController@edit', $tmsInstance))->assertStatus(403);
        $this->post(action('App\TmsInstanceController@update', $tmsInstance), [])->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $tmsInstance = TmsInstance::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\TmsInstanceController@index'))->assertStatus(403);
        $this->get(action('App\TmsInstanceController@create'))->assertStatus(403);
        $tmsInstanceData = TmsInstance::factory()->make()->toArray();
        $this->post(action('App\TmsInstanceController@store'), $tmsInstanceData)->assertStatus(403);
        $this->get(action('App\TmsInstanceController@edit', $tmsInstance))->assertStatus(403);
        $this->post(action('App\TmsInstanceController@update', $tmsInstance), [])->assertStatus(403);
    }
}
