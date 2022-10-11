<?php

namespace Tests\Feature\Permissions;

use App\Models\Directory;
use App\Models\DirectoryUser;
use App\Models\User;
use Tests\TestCase;

class DirectoryControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $directory = Directory::inRandomOrder()->first();
        $directoryUser = DirectoryUser::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\DirectoryController@index'))->assertStatus(200);
        $this->get(action('App\DirectoryController@create'))->assertStatus(200);
        $directoryData = Directory::factory()->make()->toArray();
        $this->post(action('App\DirectoryController@store'), $directoryData)->assertRedirectContains(action('App\DirectoryController@index'));
        $this->get(action('App\DirectoryController@edit', $directory))->assertStatus(200);
        $this->post(action('App\DirectoryController@update', $directory))->assertValid()->assertRedirect(action('App\DirectoryController@index'));
        $this->get(action('App\DirectoryUserController@edit', $directoryUser))->assertStatus(200);
        $this->post(action('App\DirectoryUserController@update', $directoryUser))->assertValid()->assertRedirect(action('App\UserController@show', $directoryUser->user));
        $this->delete(action('App\DirectoryController@destroy', $directory))->assertRedirect(action('App\DirectoryController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $directory = Directory::inRandomOrder()->first();
        $directoryUser = DirectoryUser::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\DirectoryController@index'))->assertStatus(403);
        $this->get(action('App\DirectoryController@create'))->assertStatus(403);
        $directoryData = Directory::factory()->make()->toArray();
        $this->post(action('App\DirectoryController@store'), $directoryData)->assertStatus(403);
        $this->get(action('App\DirectoryController@edit', $directory))->assertStatus(403);
        $this->post(action('App\DirectoryController@update', $directory))->assertStatus(403);
        $this->get(action('App\DirectoryUserController@edit', $directoryUser))->assertStatus(403);
        $this->post(action('App\DirectoryUserController@update', $directoryUser))->assertStatus(403);
        $this->delete(action('App\DirectoryController@destroy', $directory))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $directory = Directory::inRandomOrder()->first();
        $directoryUser = DirectoryUser::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\DirectoryController@index'))->assertStatus(403);
        $this->get(action('App\DirectoryController@create'))->assertStatus(403);
        $directoryData = Directory::factory()->make()->toArray();
        $this->post(action('App\DirectoryController@store'), $directoryData)->assertStatus(403);
        $this->get(action('App\DirectoryController@edit', $directory))->assertStatus(403);
        $this->post(action('App\DirectoryController@update', $directory))->assertStatus(403);
        $this->get(action('App\DirectoryUserController@edit', $directoryUser))->assertStatus(403);
        $this->post(action('App\DirectoryUserController@update', $directoryUser))->assertStatus(403);
        $this->delete(action('App\DirectoryController@destroy', $directory))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $directory = Directory::inRandomOrder()->first();
        $directoryUser = DirectoryUser::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\DirectoryController@index'))->assertStatus(403);
        $this->get(action('App\DirectoryController@create'))->assertStatus(403);
        $directoryData = Directory::factory()->make()->toArray();
        $this->post(action('App\DirectoryController@store'), $directoryData)->assertStatus(403);
        $this->get(action('App\DirectoryController@edit', $directory))->assertStatus(403);
        $this->post(action('App\DirectoryController@update', $directory))->assertStatus(403);
        $this->get(action('App\DirectoryUserController@edit', $directoryUser))->assertStatus(403);
        $this->post(action('App\DirectoryUserController@update', $directoryUser))->assertStatus(403);
        $this->delete(action('App\DirectoryController@destroy', $directory))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $directory = Directory::inRandomOrder()->first();
        $directoryUser = DirectoryUser::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\DirectoryController@index'))->assertStatus(403);
        $this->get(action('App\DirectoryController@create'))->assertStatus(403);
        $directoryData = Directory::factory()->make()->toArray();
        $this->post(action('App\DirectoryController@store'), $directoryData)->assertStatus(403);
        $this->get(action('App\DirectoryController@edit', $directory))->assertStatus(403);
        $this->post(action('App\DirectoryController@update', $directory))->assertStatus(403);
        $this->get(action('App\DirectoryUserController@edit', $directoryUser))->assertStatus(403);
        $this->post(action('App\DirectoryUserController@update', $directoryUser))->assertStatus(403);
        $this->delete(action('App\DirectoryController@destroy', $directory))->assertStatus(403);
    }
}
