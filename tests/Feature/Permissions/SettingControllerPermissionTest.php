<?php

namespace Tests\Feature\Permissions;

use App\Models\User;
use Tests\TestCase;

class SettingControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $this->actingAs($admin);

        $this->get(action('App\SettingsController@edit'))->assertStatus(200);
        $this->post(action('App\SettingsController@update'))->assertRedirect(action('App\SettingsController@update'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();

        $this->actingAs($agent);

        $this->get(action('App\SettingsController@edit'))->assertStatus(200);
        $this->post(action('App\SettingsController@update'))->assertRedirect(action('App\SettingsController@update'));
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\SettingsController@edit'))->assertStatus(200);
        $this->post(action('App\SettingsController@update'))->assertRedirect(action('App\SettingsController@update'));
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();

        $this->actingAs($regularUser);

        $this->get(action('App\SettingsController@edit'))->assertStatus(403);
        $this->post(action('App\SettingsController@update'))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();

        $this->actingAs($developer);

        $this->get(action('App\SettingsController@edit'))->assertStatus(403);
        $this->post(action('App\SettingsController@update'))->assertStatus(403);
    }
}
