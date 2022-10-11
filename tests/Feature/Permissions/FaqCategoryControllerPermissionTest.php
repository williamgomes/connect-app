<?php

namespace Tests\Feature\Permissions;

use App\Models\FaqCategory;
use App\Models\User;
use Tests\TestCase;

class FaqCategoryControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\FaqCategoryController@index'))->assertStatus(200);
        $this->get(action('App\FaqCategoryController@create'))->assertStatus(200);

        $faqCategoryData = FaqCategory::factory()->make()->toArray();
        $this->post(action('App\FaqCategoryController@store'), $faqCategoryData)->assertValid()->assertRedirectContains(action('App\FaqCategoryController@show', ''));
        $this->get(action('App\FaqCategoryController@show', $faqCategory))->assertStatus(200);
        $this->get(action('App\FaqCategoryController@edit', $faqCategory))->assertStatus(200);
        $this->post(action('App\FaqCategoryController@update', $faqCategory), [])->assertValid()->assertRedirectContains(action('App\FaqCategoryController@show', $faqCategory));
        $deleteResponse = $this->delete(action('App\FaqCategoryController@destroy', $faqCategory));
        if ($faqCategory->faqs->count() || $faqCategory->categories->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\FaqCategoryController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\FaqCategoryController@index'))->assertStatus(200);
        $this->get(action('App\FaqCategoryController@create'))->assertStatus(200);

        $faqCategoryData = FaqCategory::factory()->make()->toArray();
        $this->post(action('App\FaqCategoryController@store'), $faqCategoryData)->assertValid()->assertRedirectContains(action('App\FaqCategoryController@show', ''));
        $this->get(action('App\FaqCategoryController@show', $faqCategory))->assertStatus(200);
        $this->get(action('App\FaqCategoryController@edit', $faqCategory))->assertStatus(200);
        $this->post(action('App\FaqCategoryController@update', $faqCategory), [])->assertValid()->assertRedirectContains(action('App\FaqCategoryController@show', $faqCategory));
        $deleteResponse = $this->delete(action('App\FaqCategoryController@destroy', $faqCategory));
        if ($faqCategory->faqs->count() || $faqCategory->categories->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\FaqCategoryController@index'));
        }
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\FaqCategoryController@index'))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@create'))->assertStatus(403);

        $faqCategoryData = FaqCategory::factory()->make()->toArray();
        $this->post(action('App\FaqCategoryController@store'), $faqCategoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\FaqCategoryController@show', $faqCategory))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@edit', $faqCategory))->assertStatus(403);
        $this->post(action('App\FaqCategoryController@update', $faqCategory))->assertStatus(403);
        $this->delete(action('App\FaqCategoryController@destroy', $faqCategory))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\FaqCategoryController@index'))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@create'))->assertStatus(403);

        $faqCategoryData = FaqCategory::factory()->make()->toArray();
        $this->post(action('App\FaqCategoryController@store'), $faqCategoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\FaqCategoryController@show', $faqCategory))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@edit', $faqCategory))->assertStatus(403);
        $this->post(action('App\FaqCategoryController@update', $faqCategory))->assertStatus(403);
        $this->delete(action('App\FaqCategoryController@destroy', $faqCategory))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\FaqCategoryController@index'))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@create'))->assertStatus(403);

        $faqCategoryData = FaqCategory::factory()->make()->toArray();
        $this->post(action('App\FaqCategoryController@store'), $faqCategoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\FaqCategoryController@show', $faqCategory))->assertStatus(403);
        $this->get(action('App\FaqCategoryController@edit', $faqCategory))->assertStatus(403);
        $this->post(action('App\FaqCategoryController@update', $faqCategory))->assertStatus(403);
        $this->delete(action('App\FaqCategoryController@destroy', $faqCategory))->assertStatus(403);
    }
}
