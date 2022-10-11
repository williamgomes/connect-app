<?php

namespace Tests\Feature\Permissions;

use App\Models\User;
use Tests\TestCase;

class DocumentControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $this->actingAs($admin);

        $document = $this->storeFakeDocument($admin);
        $this->get(action('App\DocumentController@download', $document))->assertStatus(200);
        $this->get(action('App\DocumentController@view', $document))->assertStatus(200);
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();

        $this->actingAs($agent);

        $document = $this->storeFakeDocument($agent);
        $this->get(action('App\DocumentController@download', $document))->assertStatus(403);
        $this->get(action('App\DocumentController@view', $document))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();

        $this->actingAs($reportingUser);

        $document = $this->storeFakeDocument($reportingUser);
        $this->get(action('App\DocumentController@download', $document))->assertStatus(403);
        $this->get(action('App\DocumentController@view', $document))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();

        $this->actingAs($regularUser);

        $document = $this->storeFakeDocument($regularUser);
        $this->get(action('App\DocumentController@download', $document))->assertStatus(403);
        $this->get(action('App\DocumentController@view', $document))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();

        $this->actingAs($developer);

        $document = $this->storeFakeDocument($developer);
        $this->get(action('App\DocumentController@download', $document))->assertStatus(403);
        $this->get(action('App\DocumentController@view', $document))->assertStatus(403);
    }
}
