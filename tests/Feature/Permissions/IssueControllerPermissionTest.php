<?php

namespace Tests\Feature\Permissions;

use App\Models\Issue;
use App\Models\IssueAttachment;
use App\Models\User;
use Tests\TestCase;

class IssueControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $issue = Issue::inRandomOrder()->first();
        $issueAttachment = IssueAttachment::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\IssueController@index'))->assertStatus(200);
        $this->get(action('App\IssueController@create'))->assertStatus(200);

        $issueData = Issue::factory()->make()->toArray();
        $this->post(action('App\IssueController@store'), $issueData)->assertValid()->assertRedirect(action('App\IssueController@index'));
        $this->get(action('App\IssueController@show', $issue))->assertStatus(200);
        $this->get(action('App\IssueController@edit', $issue))->assertStatus(200);
        $this->post(action('App\IssueController@update', $issue), [])->assertValid()->assertRedirect(action('App\IssueController@show', $issue));
        $this->post(action('App\IssueController@addComment', $issue), ['content' => 'Test content'])->assertRedirect(action('App\IssueController@show', $issue));

        $this->get(action('App\IssueController@showAttachment', $issueAttachment))->assertStatus(200);
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $issue = Issue::inRandomOrder()->first();
        $issueAttachment = IssueAttachment::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\IssueController@index'))->assertStatus(200);
        $this->get(action('App\IssueController@create'))->assertStatus(200);

        $issueData = Issue::factory()->make()->toArray();
        $this->post(action('App\IssueController@store'), $issueData)->assertValid()->assertRedirect(action('App\IssueController@index'));
        $this->get(action('App\IssueController@show', $issue))->assertStatus(200);
        $this->get(action('App\IssueController@edit', $issue))->assertStatus(200);
        $this->post(action('App\IssueController@update', $issue), [])->assertValid()->assertRedirect(action('App\IssueController@show', $issue));
        $this->post(action('App\IssueController@addComment', $issue), ['content' => 'Test content'])->assertRedirect(action('App\IssueController@show', $issue));

        $this->get(action('App\IssueController@showAttachment', $issueAttachment))->assertStatus(200);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $issue = Issue::inRandomOrder()->first();
        $issueAttachment = IssueAttachment::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\IssueController@index'))->assertStatus(403);
        $this->get(action('App\IssueController@create'))->assertStatus(403);

        $issueData = Issue::factory()->make()->toArray();
        $this->post(action('App\IssueController@store'), $issueData)->assertValid()->assertStatus(403);
        $this->get(action('App\IssueController@show', $issue))->assertStatus(403);
        $this->get(action('App\IssueController@edit', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@update', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@addComment', $issue), ['content' => 'Test content'])->assertStatus(403);

        $this->get(action('App\IssueController@showAttachment', $issueAttachment))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $issue = Issue::inRandomOrder()->first();
        $issueAttachment = IssueAttachment::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\IssueController@index'))->assertStatus(403);
        $this->get(action('App\IssueController@create'))->assertStatus(403);

        $issueData = Issue::factory()->make()->toArray();
        $this->post(action('App\IssueController@store'), $issueData)->assertValid()->assertStatus(403);
        $this->get(action('App\IssueController@show', $issue))->assertStatus(403);
        $this->get(action('App\IssueController@edit', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@update', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@addComment', $issue), ['content' => 'Test content'])->assertStatus(403);

        $this->get(action('App\IssueController@showAttachment', $issueAttachment))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $issue = Issue::inRandomOrder()->first();
        $issueAttachment = IssueAttachment::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\IssueController@index'))->assertStatus(403);
        $this->get(action('App\IssueController@create'))->assertStatus(403);

        $issueData = Issue::factory()->make()->toArray();
        $this->post(action('App\IssueController@store'), $issueData)->assertValid()->assertStatus(403);
        $this->get(action('App\IssueController@show', $issue))->assertStatus(403);
        $this->get(action('App\IssueController@edit', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@update', $issue))->assertStatus(403);
        $this->post(action('App\IssueController@addComment', $issue), ['content' => 'Test content'])->assertStatus(403);

        $this->get(action('App\IssueController@showAttachment', $issueAttachment))->assertStatus(403);
    }
}
