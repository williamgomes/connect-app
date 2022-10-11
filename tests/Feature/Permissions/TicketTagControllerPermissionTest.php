<?php

namespace Tests\Feature\Permissions;

use App\Models\TicketTag;
use App\Models\User;
use Tests\TestCase;

class TicketTagControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $ticketTag = TicketTag::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\TicketTagController@index'))->assertStatus(200);
        $this->get(action('App\TicketTagController@create'))->assertStatus(200);

        $ticketTagData = TicketTag::factory()->make()->toArray();
        $this->post(action('App\TicketTagController@store'), $ticketTagData)->assertValid()->assertRedirect(action('App\TicketTagController@index'));
        $this->get(action('App\TicketTagController@edit', $ticketTag))->assertStatus(200);
        $this->post(action('App\TicketTagController@update', $ticketTag), [])->assertValid()->assertRedirect(action('App\TicketTagController@index'));
        $deleteResponse = $this->delete(action('App\TicketTagController@destroy', $ticketTag));
        if ($ticketTag->tickets->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\TicketTagController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $ticketTag = TicketTag::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\TicketTagController@index'))->assertStatus(403);
        $this->get(action('App\TicketTagController@create'))->assertStatus(403);

        $ticketTagData = TicketTag::factory()->make()->toArray();
        $this->post(action('App\TicketTagController@store'), $ticketTagData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketTagController@edit', $ticketTag))->assertStatus(403);
        $this->post(action('App\TicketTagController@update', $ticketTag))->assertStatus(403);
        $this->delete(action('App\TicketTagController@destroy', $ticketTag))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $ticketTag = TicketTag::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\TicketTagController@index'))->assertStatus(403);
        $this->get(action('App\TicketTagController@create'))->assertStatus(403);

        $ticketTagData = TicketTag::factory()->make()->toArray();
        $this->post(action('App\TicketTagController@store'), $ticketTagData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketTagController@edit', $ticketTag))->assertStatus(403);
        $this->post(action('App\TicketTagController@update', $ticketTag))->assertStatus(403);
        $this->delete(action('App\TicketTagController@destroy', $ticketTag))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $ticketTag = TicketTag::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\TicketTagController@index'))->assertStatus(403);
        $this->get(action('App\TicketTagController@create'))->assertStatus(403);

        $ticketTagData = TicketTag::factory()->make()->toArray();
        $this->post(action('App\TicketTagController@store'), $ticketTagData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketTagController@edit', $ticketTag))->assertStatus(403);
        $this->post(action('App\TicketTagController@update', $ticketTag))->assertStatus(403);
        $this->delete(action('App\TicketTagController@destroy', $ticketTag))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $ticketTag = TicketTag::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\TicketTagController@index'))->assertStatus(403);
        $this->get(action('App\TicketTagController@create'))->assertStatus(403);

        $ticketTagData = TicketTag::factory()->make()->toArray();
        $this->post(action('App\TicketTagController@store'), $ticketTagData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketTagController@edit', $ticketTag))->assertStatus(403);
        $this->post(action('App\TicketTagController@update', $ticketTag))->assertStatus(403);
        $this->delete(action('App\TicketTagController@destroy', $ticketTag))->assertStatus(403);
    }
}
