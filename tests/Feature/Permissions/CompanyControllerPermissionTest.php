<?php

namespace Tests\Feature\Permissions;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class CompanyControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $company = Company::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\CompanyController@index'))->assertStatus(200);
        $this->get(action('App\CompanyController@create'))->assertStatus(200);

        $companyData = $this->fakeCompanyData();
        $this->post(action('App\CompanyController@store'), $companyData)->assertValid()->assertRedirect(action('App\CompanyController@index'));
        $this->get(action('App\CompanyController@show', $company))->assertStatus(200);
        $this->get(action('App\CompanyController@edit', $company))->assertStatus(200);
        $this->post(action('App\CompanyController@update', $company), [])->assertValid()->assertRedirect(action('App\CompanyController@index'));
        $this->get(action('App\CompanyController@editRole', [$company, $role]))->assertStatus(200);
        $this->post(action('App\CompanyController@updateRole', [$company, $role]), [])->assertValid()->assertRedirect(action('App\CompanyController@show', $company));
        $this->delete(action('App\CompanyController@destroy', $company))->assertRedirect(action('App\CompanyController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $company = Company::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\CompanyController@index'))->assertStatus(403);
        $this->get(action('App\CompanyController@create'))->assertStatus(403);

        $companyData = $this->fakeCompanyData();
        $this->post(action('App\CompanyController@store'), $companyData)->assertValid()->assertStatus(403);
        $this->get(action('App\CompanyController@show', $company))->assertStatus(403);
        $this->get(action('App\CompanyController@edit', $company))->assertStatus(403);
        $this->post(action('App\CompanyController@update', $company), [])->assertStatus(403);
        $this->get(action('App\CompanyController@editRole', [$company, $role]))->assertStatus(403);
        $this->post(action('App\CompanyController@updateRole', [$company, $role]), [])->assertStatus(403);
        $this->delete(action('App\CompanyController@destroy', $company))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $company = Company::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\CompanyController@index'))->assertStatus(403);
        $this->get(action('App\CompanyController@create'))->assertStatus(403);

        $companyData = $this->fakeCompanyData();
        $this->post(action('App\CompanyController@store'), $companyData)->assertValid()->assertStatus(403);
        $this->get(action('App\CompanyController@show', $company))->assertStatus(403);
        $this->get(action('App\CompanyController@edit', $company))->assertStatus(403);
        $this->post(action('App\CompanyController@update', $company), [])->assertStatus(403);
        $this->get(action('App\CompanyController@editRole', [$company, $role]))->assertStatus(403);
        $this->post(action('App\CompanyController@updateRole', [$company, $role]), [])->assertStatus(403);
        $this->delete(action('App\CompanyController@destroy', $company))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $company = Company::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\CompanyController@index'))->assertStatus(403);
        $this->get(action('App\CompanyController@create'))->assertStatus(403);

        $companyData = $this->fakeCompanyData();
        $this->post(action('App\CompanyController@store'), $companyData)->assertValid()->assertStatus(403);
        $this->get(action('App\CompanyController@show', $company))->assertStatus(403);
        $this->get(action('App\CompanyController@edit', $company))->assertStatus(403);
        $this->post(action('App\CompanyController@update', $company), [])->assertStatus(403);
        $this->get(action('App\CompanyController@editRole', [$company, $role]))->assertStatus(403);
        $this->post(action('App\CompanyController@updateRole', [$company, $role]), [])->assertStatus(403);
        $this->delete(action('App\CompanyController@destroy', $company))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $company = Company::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\CompanyController@index'))->assertStatus(403);
        $this->get(action('App\CompanyController@create'))->assertStatus(403);

        $companyData = $this->fakeCompanyData();
        $this->post(action('App\CompanyController@store'), $companyData)->assertValid()->assertStatus(403);
        $this->get(action('App\CompanyController@show', $company))->assertStatus(403);
        $this->get(action('App\CompanyController@edit', $company))->assertStatus(403);
        $this->post(action('App\CompanyController@update', $company), [])->assertStatus(403);
        $this->get(action('App\CompanyController@editRole', [$company, $role]))->assertStatus(403);
        $this->post(action('App\CompanyController@updateRole', [$company, $role]), [])->assertStatus(403);
        $this->delete(action('App\CompanyController@destroy', $company))->assertStatus(403);
    }
}
