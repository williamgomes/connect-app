<?php

namespace Tests\Feature\Permissions;

use App\Models\Report;
use App\Models\User;
use Tests\TestCase;

class ReportControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $report = Report::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\ReportController@index'))->assertStatus(200);
        $this->get(action('App\ReportController@create'))->assertStatus(200);

        $reportData = Report::factory()->make()->toArray();
        $this->post(action('App\ReportController@store'), $reportData)->assertValid()->assertRedirect(action('App\ReportController@index'));
        $this->get(action('App\ReportController@edit', $report))->assertStatus(200);
        $this->post(action('App\ReportController@update', $report), [])->assertValid()->assertRedirect(action('App\ReportController@index'));
        $this->delete(action('App\ReportController@destroy', $report))->assertRedirect(action('App\ReportController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $report = Report::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ReportController@index'))->assertStatus(403);
        $this->get(action('App\ReportController@create'))->assertStatus(403);

        $reportData = Report::factory()->make()->toArray();
        $this->post(action('App\ReportController@store'), $reportData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportController@edit', $report))->assertStatus(403);
        $this->post(action('App\ReportController@update', $report))->assertStatus(403);
        $this->delete(action('App\ReportController@destroy', $report))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $report = Report::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ReportController@index'))->assertStatus(403);
        $this->get(action('App\ReportController@create'))->assertStatus(403);

        $reportData = Report::factory()->make()->toArray();
        $this->post(action('App\ReportController@store'), $reportData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportController@edit', $report))->assertStatus(403);
        $this->post(action('App\ReportController@update', $report))->assertStatus(403);
        $this->delete(action('App\ReportController@destroy', $report))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $report = Report::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ReportController@index'))->assertStatus(403);
        $this->get(action('App\ReportController@create'))->assertStatus(403);

        $reportData = Report::factory()->make()->toArray();
        $this->post(action('App\ReportController@store'), $reportData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportController@edit', $report))->assertStatus(403);
        $this->post(action('App\ReportController@update', $report))->assertStatus(403);
        $this->delete(action('App\ReportController@destroy', $report))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $report = Report::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ReportController@index'))->assertStatus(403);
        $this->get(action('App\ReportController@create'))->assertStatus(403);

        $reportData = Report::factory()->make()->toArray();
        $this->post(action('App\ReportController@store'), $reportData)->assertValid()->assertStatus(403);
        $this->get(action('App\ReportController@edit', $report))->assertStatus(403);
        $this->post(action('App\ReportController@update', $report))->assertStatus(403);
        $this->delete(action('App\ReportController@destroy', $report))->assertStatus(403);
    }
}
