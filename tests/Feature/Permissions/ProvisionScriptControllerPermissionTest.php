<?php

namespace Tests\Feature\Permissions;

use App\Models\ProvisionScript;
use App\Models\User;
use Tests\TestCase;

class ProvisionScriptControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ProvisionScriptController@index'))->assertStatus(200);
        $this->get(action('App\ProvisionScriptController@create'))->assertStatus(200);

        $provisionScriptData = ProvisionScript::factory()->make()->toArray();
        $this->post(action('App\ProvisionScriptController@store'), $provisionScriptData)->assertValid()->assertRedirect(action('App\ProvisionScriptController@index'));
        $this->get(action('App\ProvisionScriptController@edit', $provisionScript))->assertStatus(200);
        $this->post(action('App\ProvisionScriptController@update', $provisionScript), [])->assertValid()->assertRedirect(action('App\ProvisionScriptController@index'));
        $this->delete(action('App\ProvisionScriptController@destroy', $provisionScript))->assertRedirect(action('App\ProvisionScriptController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ProvisionScriptController@index'))->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@create'))->assertStatus(403);

        $provisionScriptData = ProvisionScript::factory()->make()->toArray();
        $this->post(action('App\ProvisionScriptController@store'), $provisionScriptData)->assertValid()->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@edit', $provisionScript))->assertStatus(403);
        $this->post(action('App\ProvisionScriptController@update', $provisionScript))->assertStatus(403);
        $this->delete(action('App\ProvisionScriptController@destroy', $provisionScript))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ProvisionScriptController@index'))->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@create'))->assertStatus(403);

        $provisionScriptData = ProvisionScript::factory()->make()->toArray();
        $this->post(action('App\ProvisionScriptController@store'), $provisionScriptData)->assertValid()->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@edit', $provisionScript))->assertStatus(403);
        $this->post(action('App\ProvisionScriptController@update', $provisionScript))->assertStatus(403);
        $this->delete(action('App\ProvisionScriptController@destroy', $provisionScript))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ProvisionScriptController@index'))->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@create'))->assertStatus(403);

        $provisionScriptData = ProvisionScript::factory()->make()->toArray();
        $this->post(action('App\ProvisionScriptController@store'), $provisionScriptData)->assertValid()->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@edit', $provisionScript))->assertStatus(403);
        $this->post(action('App\ProvisionScriptController@update', $provisionScript))->assertStatus(403);
        $this->delete(action('App\ProvisionScriptController@destroy', $provisionScript))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ProvisionScriptController@index'))->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@create'))->assertStatus(403);

        $provisionScriptData = ProvisionScript::factory()->make()->toArray();
        $this->post(action('App\ProvisionScriptController@store'), $provisionScriptData)->assertValid()->assertStatus(403);
        $this->get(action('App\ProvisionScriptController@edit', $provisionScript))->assertStatus(403);
        $this->post(action('App\ProvisionScriptController@update', $provisionScript))->assertStatus(403);
        $this->delete(action('App\ProvisionScriptController@destroy', $provisionScript))->assertStatus(403);
    }
}
