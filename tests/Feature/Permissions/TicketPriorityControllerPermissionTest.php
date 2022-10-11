<?php

namespace Tests\Feature\Permissions;

use App\Models\TicketPriority;
use App\Models\User;
use Tests\TestCase;

class TicketPriorityControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $ticketPriority = TicketPriority::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\TicketPriorityController@index'))->assertStatus(200);
        $this->get(action('App\TicketPriorityController@create'))->assertStatus(200);

        $ticketPriorityData = TicketPriority::factory()->make()->toArray();
        $this->post(action('App\TicketPriorityController@store'), $ticketPriorityData)->assertValid()->assertRedirect(action('App\TicketPriorityController@index'));
        $this->get(action('App\TicketPriorityController@edit', $ticketPriority))->assertStatus(200);
        $this->post(action('App\TicketPriorityController@update', $ticketPriority), [])->assertValid()->assertRedirect(action('App\TicketPriorityController@index'));
        $deleteResponse = $this->delete(action('App\TicketPriorityController@destroy', $ticketPriority));
        if ($ticketPriority->tickets->count()) {
            $deleteResponse->assertStatus(403);
        } else {
            $deleteResponse->assertRedirect(action('App\TicketPriorityController@index'));
        }
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $ticketPriority = TicketPriority::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\TicketPriorityController@index'))->assertStatus(403);
        $this->get(action('App\TicketPriorityController@create'))->assertStatus(403);

        $ticketPriorityData = TicketPriority::factory()->make()->toArray();
        $this->post(action('App\TicketPriorityController@store'), $ticketPriorityData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketPriorityController@edit', $ticketPriority))->assertStatus(403);
        $this->post(action('App\TicketPriorityController@update', $ticketPriority))->assertStatus(403);
        $this->delete(action('App\TicketPriorityController@destroy', $ticketPriority))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $ticketPriority = TicketPriority::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\TicketPriorityController@index'))->assertStatus(403);
        $this->get(action('App\TicketPriorityController@create'))->assertStatus(403);

        $ticketPriorityData = TicketPriority::factory()->make()->toArray();
        $this->post(action('App\TicketPriorityController@store'), $ticketPriorityData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketPriorityController@edit', $ticketPriority))->assertStatus(403);
        $this->post(action('App\TicketPriorityController@update', $ticketPriority))->assertStatus(403);
        $this->delete(action('App\TicketPriorityController@destroy', $ticketPriority))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $ticketPriority = TicketPriority::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\TicketPriorityController@index'))->assertStatus(403);
        $this->get(action('App\TicketPriorityController@create'))->assertStatus(403);

        $ticketPriorityData = TicketPriority::factory()->make()->toArray();
        $this->post(action('App\TicketPriorityController@store'), $ticketPriorityData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketPriorityController@edit', $ticketPriority))->assertStatus(403);
        $this->post(action('App\TicketPriorityController@update', $ticketPriority))->assertStatus(403);
        $this->delete(action('App\TicketPriorityController@destroy', $ticketPriority))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $ticketPriority = TicketPriority::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\TicketPriorityController@index'))->assertStatus(403);
        $this->get(action('App\TicketPriorityController@create'))->assertStatus(403);

        $ticketPriorityData = TicketPriority::factory()->make()->toArray();
        $this->post(action('App\TicketPriorityController@store'), $ticketPriorityData)->assertValid()->assertStatus(403);
        $this->get(action('App\TicketPriorityController@edit', $ticketPriority))->assertStatus(403);
        $this->post(action('App\TicketPriorityController@update', $ticketPriority))->assertStatus(403);
        $this->delete(action('App\TicketPriorityController@destroy', $ticketPriority))->assertStatus(403);
    }
}
