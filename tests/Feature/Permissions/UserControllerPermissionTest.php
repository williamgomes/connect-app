<?php

namespace Tests\Feature\Permissions;

use App\Models\User;
use Tests\TestCase;

class UserControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $randomUser = User::where('id', '!=', $admin->id)->inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\UserController@index'))->assertStatus(200);
        $this->get(action('App\UserController@create'))->assertStatus(200);

        $userData = User::factory()->make([
            'phone_number' => '47000000000',
        ])->toArray();
        $this->post(action('App\UserController@store'), $userData)->assertValid()->assertRedirectContains(action('App\UserController@show', ''));

        $this->get(action('App\UserController@show', $randomUser))->assertStatus(200);
        $this->get(action('App\UserController@edit', $randomUser))->assertStatus(200);
        $this->post(action('App\UserController@update', $randomUser), ['phone_number' => '+47000000001'])->assertValid()->assertRedirectContains(action('App\UserController@show', $randomUser));
        $this->post(action('App\UserController@activate', $randomUser))->assertRedirect(action('App\UserController@index'));
        $this->post(action('App\UserController@deactivate', $randomUser))->assertRedirect(action('App\UserController@index'));

        $fakeProfilePicture = $this->fakeProfilePicture();
        $this->post(action('App\UserController@updateProfilePicture', $randomUser), $fakeProfilePicture)->assertValid()->assertStatus(302);

        $fakeDocument = $this->fakeDocument();
        $this->post(action('App\DocumentController@store', $randomUser), ['document' => $fakeDocument])->assertValid()->assertRedirectContains(action('App\UserController@show', $randomUser));
        $this->get(action('App\UserController@tickets', $randomUser))->assertStatus(200);
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $randomUser = User::where('id', '!=', $agent->id)->inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\UserController@index'))->assertStatus(403);
        $this->get(action('App\UserController@create'))->assertStatus(403);

        $userData = User::factory()->make([
            'phone_number' => '47000000000',
        ])->toArray();
        $this->post(action('App\UserController@store'), $userData)->assertStatus(403);

        $this->get(action('App\UserController@show', $randomUser))->assertStatus(403);
        $this->get(action('App\UserController@edit', $randomUser))->assertStatus(403);

        $this->post(action('App\UserController@update', $randomUser), ['phone_number' => '+47000000001'])->assertStatus(403);

        $this->post(action('App\UserController@activate', $randomUser))->assertStatus(403);
        $this->post(action('App\UserController@deactivate', $randomUser))->assertStatus(403);

        $fakeProfilePicture = $this->fakeProfilePicture();
        $this->post(action('App\UserController@updateProfilePicture', $randomUser), $fakeProfilePicture)->assertValid()->assertStatus(302);

        $fakeDocument = $this->fakeDocument();
        $this->post(action('App\DocumentController@store', $randomUser), ['document' => $fakeDocument])->assertStatus(403);
        $this->get(action('App\UserController@tickets', $randomUser))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $randomUser = User::where('id', '!=', $reportingUser->id)->inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\UserController@index'))->assertStatus(403);
        $this->get(action('App\UserController@create'))->assertStatus(403);

        $userData = User::factory()->make([
            'phone_number' => '47000000000',
        ])->toArray();
        $this->post(action('App\UserController@store'), $userData)->assertStatus(403);

        $this->get(action('App\UserController@show', $randomUser))->assertStatus(403);
        $this->get(action('App\UserController@edit', $randomUser))->assertStatus(403);

        $this->post(action('App\UserController@update', $randomUser), ['phone_number' => '+47000000001'])->assertStatus(403);

        $this->post(action('App\UserController@activate', $randomUser))->assertStatus(403);
        $this->post(action('App\UserController@deactivate', $randomUser))->assertStatus(403);

        $fakeProfilePicture = $this->fakeProfilePicture();
        $this->post(action('App\UserController@updateProfilePicture', $randomUser), $fakeProfilePicture)->assertValid()->assertStatus(302);

        $fakeDocument = $this->fakeDocument();
        $this->post(action('App\DocumentController@store', $randomUser), ['document' => $fakeDocument])->assertStatus(403);
        $this->get(action('App\UserController@tickets', $randomUser))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $randomUser = User::where('id', '!=', $regularUser->id)->inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\UserController@index'))->assertStatus(403);
        $this->get(action('App\UserController@create'))->assertStatus(403);

        $userData = User::factory()->make([
            'phone_number' => '47000000000',
        ])->toArray();
        $this->post(action('App\UserController@store'), $userData)->assertStatus(403);

        $this->get(action('App\UserController@show', $randomUser))->assertStatus(403);
        $this->get(action('App\UserController@edit', $randomUser))->assertStatus(403);

        $this->post(action('App\UserController@update', $randomUser), ['phone_number' => '+47000000001'])->assertStatus(403);

        $this->post(action('App\UserController@activate', $randomUser))->assertStatus(403);
        $this->post(action('App\UserController@deactivate', $randomUser))->assertStatus(403);

        $fakeProfilePicture = $this->fakeProfilePicture();
        $this->post(action('App\UserController@updateProfilePicture', $randomUser), $fakeProfilePicture)->assertValid()->assertStatus($regularUser->permissions()->count() ? 302 : 403);

        $fakeDocument = $this->fakeDocument();
        $this->post(action('App\DocumentController@store', $randomUser), ['document' => $fakeDocument])->assertStatus(403);
        $this->get(action('App\UserController@tickets', $randomUser))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $randomUser = User::where('id', '!=', $developer->id)->inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\UserController@index'))->assertStatus(403);
        $this->get(action('App\UserController@create'))->assertStatus(403);

        $userData = User::factory()->make([
            'phone_number' => '47000000000',
        ])->toArray();
        $this->post(action('App\UserController@store'), $userData)->assertStatus(403);

        $this->get(action('App\UserController@show', $randomUser))->assertStatus(403);
        $this->get(action('App\UserController@edit', $randomUser))->assertStatus(403);

        $this->post(action('App\UserController@update', $randomUser), ['phone_number' => '+47000000001'])->assertStatus(403);

        $this->post(action('App\UserController@activate', $randomUser))->assertStatus(403);
        $this->post(action('App\UserController@deactivate', $randomUser))->assertStatus(403);

        $fakeProfilePicture = $this->fakeProfilePicture();
        $this->post(action('App\UserController@updateProfilePicture', $randomUser), $fakeProfilePicture)->assertValid()->assertStatus($developer->permissions()->count() ? 302 : 403);

        $fakeDocument = $this->fakeDocument();
        $this->post(action('App\DocumentController@store', $randomUser), ['document' => $fakeDocument])->assertStatus(403);
        $this->get(action('App\UserController@tickets', $randomUser))->assertStatus(403);
    }
}
