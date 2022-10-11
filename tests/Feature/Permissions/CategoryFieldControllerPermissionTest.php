<?php

namespace Tests\Feature\Permissions;

use App\Models\Category;
use App\Models\CategoryField;
use App\Models\User;
use Tests\TestCase;

class CategoryFieldControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $category = Category::inRandomOrder()->first();
        $categoryField = CategoryField::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\CategoryFieldController@create', $category))->assertStatus(200);

        $categoryFieldData = CategoryField::factory()->make()->toArray();
        $this->post(action('App\CategoryFieldController@store', $category), $categoryFieldData)->assertValid()->assertRedirect(action('App\CategoryController@edit', $category));
        $this->get(action('App\CategoryFieldController@edit', [$category, $categoryField]))->assertStatus(200);
        $this->post(action('App\CategoryFieldController@update', [$category, $categoryField]), [])->assertValid()->assertRedirect(action('App\CategoryController@edit', $category));
        $this->delete(action('App\CategoryFieldController@destroy', [$category, $categoryField]))->assertRedirect(action('App\CategoryController@edit', $category));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $category = Category::inRandomOrder()->first();
        $categoryField = CategoryField::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\CategoryFieldController@create', $category))->assertStatus(403);

        $categoryFieldData = CategoryField::factory()->make()->toArray();
        $this->post(action('App\CategoryFieldController@store', $category), $categoryFieldData)->assertStatus(403);
        $this->get(action('App\CategoryFieldController@edit', [$category, $categoryField]))->assertStatus(403);
        $this->post(action('App\CategoryFieldController@update', [$category, $categoryField]), [])->assertStatus(403);
        $this->delete(action('App\CategoryFieldController@destroy', [$category, $categoryField]))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $category = Category::inRandomOrder()->first();
        $categoryField = CategoryField::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\CategoryFieldController@create', $category))->assertStatus(403);

        $categoryFieldData = CategoryField::factory()->make()->toArray();
        $this->post(action('App\CategoryFieldController@store', $category), $categoryFieldData)->assertStatus(403);
        $this->get(action('App\CategoryFieldController@edit', [$category, $categoryField]))->assertStatus(403);
        $this->post(action('App\CategoryFieldController@update', [$category, $categoryField]), [])->assertStatus(403);
        $this->delete(action('App\CategoryFieldController@destroy', [$category, $categoryField]))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $category = Category::inRandomOrder()->first();
        $categoryField = CategoryField::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\CategoryFieldController@create', $category))->assertStatus(403);

        $categoryFieldData = CategoryField::factory()->make()->toArray();
        $this->post(action('App\CategoryFieldController@store', $category), $categoryFieldData)->assertStatus(403);
        $this->get(action('App\CategoryFieldController@edit', [$category, $categoryField]))->assertStatus(403);
        $this->post(action('App\CategoryFieldController@update', [$category, $categoryField]), [])->assertStatus(403);
        $this->delete(action('App\CategoryFieldController@destroy', [$category, $categoryField]))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $category = Category::inRandomOrder()->first();
        $categoryField = CategoryField::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\CategoryFieldController@create', $category))->assertStatus(403);

        $categoryFieldData = CategoryField::factory()->make()->toArray();
        $this->post(action('App\CategoryFieldController@store', $category), $categoryFieldData)->assertStatus(403);
        $this->get(action('App\CategoryFieldController@edit', [$category, $categoryField]))->assertStatus(403);
        $this->post(action('App\CategoryFieldController@update', [$category, $categoryField]), [])->assertStatus(403);
        $this->delete(action('App\CategoryFieldController@destroy', [$category, $categoryField]))->assertStatus(403);
    }
}
