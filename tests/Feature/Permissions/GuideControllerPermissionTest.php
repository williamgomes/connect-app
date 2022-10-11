<?php

namespace Tests\Feature\Permissions;

use App\Models\Guide;
use App\Models\User;
use Tests\TestCase;

class GuideControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\GuideController@index'))->assertStatus(200);
        $this->get(action('App\GuideController@create'))->assertStatus(200);

        $guideData = Guide::factory()->make()->toArray();
        $this->post(action('App\GuideController@store'), $guideData)->assertValid()->assertRedirectContains(action('App\GuideController@index'));
        $this->get(action('App\GuideController@show', $guide))->assertStatus(200);
        $this->get(action('App\GuideController@edit', $guide))->assertStatus(200);
        $this->post(action('App\GuideController@update', $guide), [])->assertValid()->assertRedirect(action('App\GuideController@index'));
        $this->delete(action('App\GuideController@destroy', $guide))->assertRedirect(action('App\GuideController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\GuideController@index'))->assertStatus(403);
        $this->get(action('App\GuideController@create'))->assertStatus(403);

        $guideData = Guide::factory()->make()->toArray();
        $this->post(action('App\GuideController@store'), $guideData)->assertValid()->assertStatus(403);
        $this->get(action('App\GuideController@show', $guide))->assertStatus(403);
        $this->get(action('App\GuideController@edit', $guide))->assertStatus(403);
        $this->post(action('App\GuideController@update', $guide))->assertStatus(403);
        $this->delete(action('App\GuideController@destroy', $guide))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\GuideController@index'))->assertStatus(403);
        $this->get(action('App\GuideController@create'))->assertStatus(403);

        $guideData = Guide::factory()->make()->toArray();
        $this->post(action('App\GuideController@store'), $guideData)->assertValid()->assertStatus(403);
        $this->get(action('App\GuideController@show', $guide))->assertStatus(403);
        $this->get(action('App\GuideController@edit', $guide))->assertStatus(403);
        $this->post(action('App\GuideController@update', $guide))->assertStatus(403);
        $this->delete(action('App\GuideController@destroy', $guide))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\GuideController@index'))->assertStatus(403);
        $this->get(action('App\GuideController@create'))->assertStatus(403);

        $guideData = Guide::factory()->make()->toArray();
        $this->post(action('App\GuideController@store'), $guideData)->assertValid()->assertStatus(403);
        $this->get(action('App\GuideController@show', $guide))->assertStatus(403);
        $this->get(action('App\GuideController@edit', $guide))->assertStatus(403);
        $this->post(action('App\GuideController@update', $guide))->assertStatus(403);
        $this->delete(action('App\GuideController@destroy', $guide))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\GuideController@index'))->assertStatus(403);
        $this->get(action('App\GuideController@create'))->assertStatus(403);

        $guideData = Guide::factory()->make()->toArray();
        $this->post(action('App\GuideController@store'), $guideData)->assertValid()->assertStatus(403);
        $this->get(action('App\GuideController@show', $guide))->assertStatus(403);
        $this->get(action('App\GuideController@edit', $guide))->assertStatus(403);
        $this->post(action('App\GuideController@update', $guide))->assertStatus(403);
        $this->delete(action('App\GuideController@destroy', $guide))->assertStatus(403);
    }
}
