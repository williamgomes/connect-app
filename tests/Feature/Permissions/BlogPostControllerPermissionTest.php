<?php

namespace Tests\Feature\Permissions;

use App\Models\BlogPost;
use App\Models\User;
use Tests\TestCase;

class BlogPostControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $blogPost = BlogPost::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\BlogPostController@index'))->assertStatus(200);
        $this->get(action('App\BlogPostController@create'))->assertStatus(200);

        $blogPostData = BlogPost::factory()->make()->toArray();
        $this->post(action('App\BlogPostController@store'), $blogPostData)->assertValid()->assertRedirect(action('App\BlogPostController@index'));
        $this->get(action('App\BlogPostController@edit', $blogPost))->assertStatus(200);
        $this->post(action('App\BlogPostController@update', $blogPost), [])->assertValid()->assertRedirect(action('App\BlogPostController@index'));
        $this->delete(action('App\BlogPostController@destroy', $blogPost))->assertRedirect(action('App\BlogPostController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $blogPost = BlogPost::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\BlogPostController@index'))->assertStatus(200);
        $this->get(action('App\BlogPostController@create'))->assertStatus(200);

        $blogPostData = BlogPost::factory()->make()->toArray();
        $this->post(action('App\BlogPostController@store'), $blogPostData)->assertValid()->assertRedirect(action('App\BlogPostController@index'));
        $this->get(action('App\BlogPostController@edit', $blogPost))->assertStatus(200);
        $this->post(action('App\BlogPostController@update', $blogPost), [])->assertValid()->assertRedirect(action('App\BlogPostController@index'));
        $this->delete(action('App\BlogPostController@destroy', $blogPost))->assertRedirect(action('App\BlogPostController@index'));
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $blogPost = BlogPost::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\BlogPostController@index'))->assertStatus(403);
        $this->get(action('App\BlogPostController@create'))->assertStatus(403);

        $blogPostData = BlogPost::factory()->make()->toArray();
        $this->post(action('App\BlogPostController@store'), $blogPostData)->assertValid()->assertStatus(403);
        $this->get(action('App\BlogPostController@edit', $blogPost))->assertStatus(403);
        $this->post(action('App\BlogPostController@update', $blogPost))->assertStatus(403);
        $this->delete(action('App\BlogPostController@destroy', $blogPost))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $blogPost = BlogPost::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\BlogPostController@index'))->assertStatus(403);
        $this->get(action('App\BlogPostController@create'))->assertStatus(403);

        $blogPostData = BlogPost::factory()->make()->toArray();
        $this->post(action('App\BlogPostController@store'), $blogPostData)->assertValid()->assertStatus(403);
        $this->get(action('App\BlogPostController@edit', $blogPost))->assertStatus(403);
        $this->post(action('App\BlogPostController@update', $blogPost))->assertStatus(403);
        $this->delete(action('App\BlogPostController@destroy', $blogPost))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $blogPost = BlogPost::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\BlogPostController@index'))->assertStatus(403);
        $this->get(action('App\BlogPostController@create'))->assertStatus(403);

        $blogPostData = BlogPost::factory()->make()->toArray();
        $this->post(action('App\BlogPostController@store'), $blogPostData)->assertValid()->assertStatus(403);
        $this->get(action('App\BlogPostController@edit', $blogPost))->assertStatus(403);
        $this->post(action('App\BlogPostController@update', $blogPost))->assertStatus(403);
        $this->delete(action('App\BlogPostController@destroy', $blogPost))->assertStatus(403);
    }
}
