<?php

namespace Tests\Feature\Permissions;

use App\Models\ApiApplication;
use App\Models\ApiApplicationToken;
use App\Models\User;
use Tests\TestCase;

class ApiApplicationTokenControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();
        $apiApplicationToken = ApiApplicationToken::inRandomOrder()->first();

        $this->actingAs($admin);
        $this->get(action('App\ApiApplicationTokenController@create', $apiApplication))->assertStatus(200);

        $apiApplicationTokenMake = ApiApplicationToken::factory()->make();
        $apiApplicationTokenData = array_merge(ApiApplicationToken::factory()->make()->toArray(), ['token' => $apiApplicationTokenMake->api_token]);

        $this->post(action('App\ApiApplicationTokenController@store', $apiApplication), $apiApplicationTokenData)->assertRedirectContains(action('App\ApiApplicationController@index'));
        $this->post(action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]))->assertValid()->assertRedirect(action('App\ApiApplicationController@show', $apiApplication));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();
        $apiApplicationToken = ApiApplicationToken::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\ApiApplicationTokenController@create', $apiApplication))->assertStatus(403);

        $apiApplicationTokenMake = ApiApplicationToken::factory()->make();
        $apiApplicationTokenData = array_merge(ApiApplicationToken::factory()->make()->toArray(), ['token' => $apiApplicationTokenMake->api_token]);

        $this->post(action('App\ApiApplicationTokenController@store', $apiApplication), $apiApplicationTokenData)->assertStatus(403);
        $this->post(action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();
        $apiApplicationToken = ApiApplicationToken::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\ApiApplicationTokenController@create', $apiApplication))->assertStatus(403);

        $apiApplicationTokenMake = ApiApplicationToken::factory()->make();
        $apiApplicationTokenData = array_merge(ApiApplicationToken::factory()->make()->toArray(), ['token' => $apiApplicationTokenMake->api_token]);

        $this->post(action('App\ApiApplicationTokenController@store', $apiApplication), $apiApplicationTokenData)->assertStatus(403);
        $this->post(action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();
        $apiApplicationToken = ApiApplicationToken::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\ApiApplicationTokenController@create', $apiApplication))->assertStatus(403);

        $apiApplicationTokenMake = ApiApplicationToken::factory()->make();
        $apiApplicationTokenData = array_merge(ApiApplicationToken::factory()->make()->toArray(), ['token' => $apiApplicationTokenMake->api_token]);

        $this->post(action('App\ApiApplicationTokenController@store', $apiApplication), $apiApplicationTokenData)->assertStatus(403);
        $this->post(action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $apiApplication = ApiApplication::inRandomOrder()->first();
        $apiApplicationToken = ApiApplicationToken::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\ApiApplicationTokenController@create', $apiApplication))->assertStatus(403);

        $apiApplicationTokenMake = ApiApplicationToken::factory()->make();
        $apiApplicationTokenData = array_merge(ApiApplicationToken::factory()->make()->toArray(), ['token' => $apiApplicationTokenMake->api_token]);

        $this->post(action('App\ApiApplicationTokenController@store', $apiApplication), $apiApplicationTokenData)->assertStatus(403);
        $this->post(action('App\ApiApplicationTokenController@revoke', [$apiApplication, $apiApplicationToken]))->assertStatus(403);
    }
}
