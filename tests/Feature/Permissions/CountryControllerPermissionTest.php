<?php

namespace Tests\Feature\Permissions;

use App\Models\Country;
use App\Models\User;
use Tests\TestCase;

class CountryControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $country = Country::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\CountryController@index'))->assertStatus(200);
        $this->get(action('App\CountryController@create'))->assertStatus(200);

        $countryData = Country::factory()->make()->toArray();
        $this->post(action('App\CountryController@store'), $countryData)->assertValid()->assertRedirect(action('App\CountryController@index'));
        $this->get(action('App\CountryController@edit', $country))->assertStatus(200);
        $this->post(action('App\CountryController@update', $country), [])->assertValid()->assertRedirect(action('App\CountryController@index'));
        $deleteResponse = $this->delete(action('App\CountryController@destroy', $country));
        if ($country->tickets->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\CountryController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $country = Country::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\CountryController@index'))->assertStatus(403);
        $this->get(action('App\CountryController@create'))->assertStatus(403);

        $countryData = Country::factory()->make()->toArray();
        $this->post(action('App\CountryController@store'), $countryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CountryController@edit', $country))->assertStatus(403);
        $this->post(action('App\CountryController@update', $country))->assertStatus(403);
        $this->delete(action('App\CountryController@destroy', $country))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $country = Country::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\CountryController@index'))->assertStatus(403);
        $this->get(action('App\CountryController@create'))->assertStatus(403);

        $countryData = Country::factory()->make()->toArray();
        $this->post(action('App\CountryController@store'), $countryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CountryController@edit', $country))->assertStatus(403);
        $this->post(action('App\CountryController@update', $country))->assertStatus(403);
        $this->delete(action('App\CountryController@destroy', $country))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $country = Country::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\CountryController@index'))->assertStatus(403);
        $this->get(action('App\CountryController@create'))->assertStatus(403);

        $countryData = Country::factory()->make()->toArray();
        $this->post(action('App\CountryController@store'), $countryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CountryController@edit', $country))->assertStatus(403);
        $this->post(action('App\CountryController@update', $country))->assertStatus(403);
        $this->delete(action('App\CountryController@destroy', $country))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $country = Country::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\CountryController@index'))->assertStatus(403);
        $this->get(action('App\CountryController@create'))->assertStatus(403);

        $countryData = Country::factory()->make()->toArray();
        $this->post(action('App\CountryController@store'), $countryData)->assertValid()->assertStatus(403);
        $this->get(action('App\CountryController@edit', $country))->assertStatus(403);
        $this->post(action('App\CountryController@update', $country))->assertStatus(403);
        $this->delete(action('App\CountryController@destroy', $country))->assertStatus(403);
    }
}
