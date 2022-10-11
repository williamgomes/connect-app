<?php

namespace Tests\Feature\Permissions;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\User;
use Tests\TestCase;

class FaqControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();
        $faq = Faq::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\FaqController@create', $faqCategory))->assertStatus(200);

        $faqData = Faq::factory()->make()->toArray();
        $this->post(action('App\FaqController@store', $faqCategory), $faqData)->assertValid()->assertRedirect(action('App\FaqCategoryController@show', $faqCategory));
        $this->get(action('App\FaqController@edit', [$faqCategory, $faq]))->assertStatus(200);
        $this->post(action('App\FaqController@update', [$faqCategory, $faq]), [])->assertValid()->assertRedirect(action('App\FaqCategoryController@show', $faqCategory));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();
        $faq = Faq::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\FaqController@create', $faqCategory))->assertStatus(200);

        $faqData = Faq::factory()->make()->toArray();
        $this->post(action('App\FaqController@store', $faqCategory), $faqData)->assertValid()->assertRedirect(action('App\FaqCategoryController@show', $faqCategory));
        $this->get(action('App\FaqController@edit', [$faqCategory, $faq]))->assertStatus(200);
        $this->post(action('App\FaqController@update', [$faqCategory, $faq]), [])->assertValid()->assertRedirect(action('App\FaqCategoryController@show', $faqCategory));
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();
        $faq = Faq::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\FaqController@create', $faqCategory))->assertStatus(403);

        $faqData = Faq::factory()->make()->toArray();
        $this->post(action('App\FaqController@store', $faqCategory), $faqData)->assertStatus(403);
        $this->get(action('App\FaqController@edit', [$faqCategory, $faq]))->assertStatus(403);
        $this->post(action('App\FaqController@update', [$faqCategory, $faq]), [])->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();
        $faq = Faq::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\FaqController@create', $faqCategory))->assertStatus(403);

        $faqData = Faq::factory()->make()->toArray();
        $this->post(action('App\FaqController@store', $faqCategory), $faqData)->assertStatus(403);
        $this->get(action('App\FaqController@edit', [$faqCategory, $faq]))->assertStatus(403);
        $this->post(action('App\FaqController@update', [$faqCategory, $faq]), [])->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $faqCategory = FaqCategory::inRandomOrder()->first();
        $faq = Faq::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\FaqController@create', $faqCategory))->assertStatus(403);

        $faqData = Faq::factory()->make()->toArray();
        $this->post(action('App\FaqController@store', $faqCategory), $faqData)->assertStatus(403);
        $this->get(action('App\FaqController@edit', [$faqCategory, $faq]))->assertStatus(403);
        $this->post(action('App\FaqController@update', [$faqCategory, $faq]), [])->assertStatus(403);
    }
}
