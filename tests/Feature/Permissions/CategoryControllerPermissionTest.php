<?php

namespace Tests\Feature\Permissions;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $category = Category::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\CategoryController@index'))->assertStatus(200);
        $this->get(action('App\CategoryController@create'))->assertStatus(200);

        $categoryData = Category::factory()->make()->toArray();
        $this->post(action('App\CategoryController@store'), $categoryData)->assertValid()->assertRedirect(action('App\CategoryController@index'));
        $this->get(action('App\CategoryController@edit', $category))->assertStatus(200);
        $this->post(action('App\CategoryController@update', $category), [])->assertValid()->assertRedirect(action('App\CategoryController@index'));
        $deleteResponse = $this->delete(action('App\CategoryController@destroy', $category));
        if ($category->tickets->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\CategoryController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $category = Category::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\CategoryController@index'))->assertStatus(403);
        $this->get(action('App\CategoryController@create'))->assertStatus(403);

        $categoryData = Category::factory()->make()->toArray();
        $this->post(action('App\CategoryController@store'), $categoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CategoryController@edit', $category))->assertStatus(403);
        $this->post(action('App\CategoryController@update', $category))->assertStatus(403);
        $this->delete(action('App\CategoryController@destroy', $category))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $category = Category::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\CategoryController@index'))->assertStatus(403);
        $this->get(action('App\CategoryController@create'))->assertStatus(403);

        $categoryData = Category::factory()->make()->toArray();
        $this->post(action('App\CategoryController@store'), $categoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CategoryController@edit', $category))->assertStatus(403);
        $this->post(action('App\CategoryController@update', $category))->assertStatus(403);
        $this->delete(action('App\CategoryController@destroy', $category))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $category = Category::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\CategoryController@index'))->assertStatus(403);
        $this->get(action('App\CategoryController@create'))->assertStatus(403);

        $categoryData = Category::factory()->make()->toArray();
        $this->post(action('App\CategoryController@store'), $categoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CategoryController@edit', $category))->assertStatus(403);
        $this->post(action('App\CategoryController@update', $category))->assertStatus(403);
        $this->delete(action('App\CategoryController@destroy', $category))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $category = Category::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\CategoryController@index'))->assertStatus(403);
        $this->get(action('App\CategoryController@create'))->assertStatus(403);

        $categoryData = Category::factory()->make()->toArray();
        $this->post(action('App\CategoryController@store'), $categoryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CategoryController@edit', $category))->assertStatus(403);
        $this->post(action('App\CategoryController@update', $category))->assertStatus(403);
        $this->delete(action('App\CategoryController@destroy', $category))->assertStatus(403);
    }
}
