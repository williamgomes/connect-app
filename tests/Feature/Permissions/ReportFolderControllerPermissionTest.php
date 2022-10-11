<?php

namespace Tests\Feature\Permissions;

use App\Models\ReportFolder;
use App\Models\User;
use Tests\TestCase;

class ReportFolderControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $reportFolder = ReportFolder::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ReportFolderController@index'))->assertStatus(200);
        $this->get(action('App\ReportFolderController@create'))->assertStatus(200);

        $reportFolderData = ReportFolder::factory()->make()->toArray();
        $this->post(action('App\ReportFolderController@store'), $reportFolderData)->assertValid()->assertRedirectContains(action('App\ReportFolderController@show', ''));
        $this->get(action('App\ReportFolderController@show', $reportFolder))->assertStatus(200);
        $this->get(action('App\ReportFolderController@edit', $reportFolder))->assertStatus(200);
        $this->post(action('App\ReportFolderController@update', $reportFolder), [])->assertValid()->assertRedirect(action('App\ReportFolderController@show', $reportFolder));
        $this->delete(action('App\ReportFolderController@destroy', $reportFolder))->assertRedirect(action('App\ReportFolderController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $reportFolder = ReportFolder::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ReportFolderController@index'))->assertStatus(403);
        $this->get(action('App\ReportFolderController@create'))->assertStatus(403);

        $reportFolderData = ReportFolder::factory()->make()->toArray();
        $this->post(action('App\ReportFolderController@store'), $reportFolderData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportFolderController@show', $reportFolder))->assertStatus(403);
        $this->get(action('App\ReportFolderController@edit', $reportFolder))->assertStatus(403);
        $this->post(action('App\ReportFolderController@update', $reportFolder))->assertStatus(403);
        $this->delete(action('App\ReportFolderController@destroy', $reportFolder))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $reportFolder = ReportFolder::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ReportFolderController@index'))->assertStatus(403);
        $this->get(action('App\ReportFolderController@create'))->assertStatus(403);

        $reportFolderData = ReportFolder::factory()->make()->toArray();
        $this->post(action('App\ReportFolderController@store'), $reportFolderData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportFolderController@show', $reportFolder))->assertStatus(403);
        $this->get(action('App\ReportFolderController@edit', $reportFolder))->assertStatus(403);
        $this->post(action('App\ReportFolderController@update', $reportFolder))->assertStatus(403);
        $this->delete(action('App\ReportFolderController@destroy', $reportFolder))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $reportFolder = ReportFolder::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ReportFolderController@index'))->assertStatus(403);
        $this->get(action('App\ReportFolderController@create'))->assertStatus(403);

        $reportFolderData = ReportFolder::factory()->make()->toArray();
        $this->post(action('App\ReportFolderController@store'), $reportFolderData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportFolderController@show', $reportFolder))->assertStatus(403);
        $this->get(action('App\ReportFolderController@edit', $reportFolder))->assertStatus(403);
        $this->post(action('App\ReportFolderController@update', $reportFolder))->assertStatus(403);
        $this->delete(action('App\ReportFolderController@destroy', $reportFolder))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $reportFolder = ReportFolder::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ReportFolderController@index'))->assertStatus(403);
        $this->get(action('App\ReportFolderController@create'))->assertStatus(403);

        $reportFolderData = ReportFolder::factory()->make()->toArray();
        $this->post(action('App\ReportFolderController@store'), $reportFolderData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportFolderController@show', $reportFolder))->assertStatus(403);
        $this->get(action('App\ReportFolderController@edit', $reportFolder))->assertStatus(403);
        $this->post(action('App\ReportFolderController@update', $reportFolder))->assertStatus(403);
        $this->delete(action('App\ReportFolderController@destroy', $reportFolder))->assertStatus(403);
    }
}
