<?php

namespace Tests\Feature\Permissions;

use App\Models\Ticket;
use App\Models\TicketCommentAttachment;
use App\Models\TicketTag;
use App\Models\User;
use Tests\TestCase;

class TicketControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $ticket = Ticket::inRandomOrder()->first();
        $ticketCommentAttachment = TicketCommentAttachment::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\TicketController@index'))->assertStatus(200);
        $this->get(action('App\TicketController@create'))->assertStatus(200);
        $this->get(action('App\TicketController@downloadAttachment', $ticketCommentAttachment))->assertStatus(200);
        $ticketData = Ticket::factory()->make()->toArray();
        $this->post(action('App\TicketController@store'), $ticketData)->assertRedirectContains(action('App\TicketController@show', ''));
        $this->get(action('App\TicketController@show', $ticket))->assertStatus(200);
        $this->get(action('App\TicketController@edit', $ticket))->assertStatus(200);
        $this->post(action('App\TicketController@update', $ticket), [])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@reply', $ticket), ['content' => 'New Test Comment'])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@remindRequester', $ticket))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@markAsSolved', $ticket))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@createWatcher', $ticket), ['user_id' => $admin->id])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->delete(action('App\TicketController@destroyWatcher', [$ticket, $admin->id]))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@createTicketTag', $ticket), ['ticket_tags' => [TicketTag::inRandomOrder()->first()->id]])->assertRedirect(action('App\TicketController@show', $ticket));
        $ticketTag = TicketTag::factory()->create();
        $this->delete(action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]))->assertRedirect(action('App\TicketController@show', $ticket));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $ticket = Ticket::inRandomOrder()->first();
        $ticketCommentAttachment = TicketCommentAttachment::inRandomOrder()->first();

        $this->actingAs($agent);

        $this->get(action('App\TicketController@index'))->assertStatus(200);
        $this->get(action('App\TicketController@create'))->assertStatus(200);
        $this->get(action('App\TicketController@downloadAttachment', $ticketCommentAttachment))->assertStatus(200);
        $ticketData = Ticket::factory()->make()->toArray();
        $this->post(action('App\TicketController@store'), $ticketData)->assertRedirectContains(action('App\TicketController@show', ''));
        $this->get(action('App\TicketController@show', $ticket))->assertStatus(200);
        $this->get(action('App\TicketController@edit', $ticket))->assertStatus(200);
        $this->post(action('App\TicketController@update', $ticket), [])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@reply', $ticket), ['content' => 'New Test Comment'])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@remindRequester', $ticket))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@markAsSolved', $ticket))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@createWatcher', $ticket), ['user_id' => $agent->id])->assertValid()->assertRedirect(action('App\TicketController@show', $ticket));
        $this->delete(action('App\TicketController@destroyWatcher', [$ticket, $agent->id]))->assertRedirect(action('App\TicketController@show', $ticket));
        $this->post(action('App\TicketController@createTicketTag', $ticket), ['ticket_tags' => [TicketTag::inRandomOrder()->first()->id]])->assertRedirect(action('App\TicketController@show', $ticket));
        $ticketTag = TicketTag::factory()->create();
        $this->delete(action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]))->assertRedirect(action('App\TicketController@show', $ticket));
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $ticketCommentAttachment = TicketCommentAttachment::inRandomOrder()->first();
        // Taking ticket through the ticket attachment as downloadAttachment() requires a ticket which 100% has attachment.
        $ticket = $ticketCommentAttachment->comment->ticket;
        $userIsRequester = $reportingUser->id == $ticket->requester->id;

        $this->actingAs($reportingUser);

        $this->get(action('App\TicketController@index'))->assertStatus(403);
        $this->get(action('App\TicketController@create'))->assertStatus(200);
        $this->get(action('App\TicketController@downloadAttachment', $ticketCommentAttachment))->assertStatus($userIsRequester ? 200 : 403);
        $ticketData = Ticket::factory()->make()->toArray();
        $this->post(action('App\TicketController@store'), $ticketData)->assertRedirectContains(action('App\TicketController@show', ''));
        $this->get(action('App\TicketController@show', $ticket))->assertStatus($userIsRequester ? 200 : 403);
        $this->get(action('App\TicketController@edit', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@update', $ticket), [])->assertStatus(403);
        $this->post(action('App\TicketController@reply', $ticket), ['content' => 'New Test Comment'])->assertStatus($userIsRequester ? 302 : 403);
        $this->post(action('App\TicketController@remindRequester', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@markAsSolved', $ticket))->assertStatus($userIsRequester ? 302 : 403);
        $this->post(action('App\TicketController@createWatcher', $ticket), ['user_id' => $reportingUser->id])->assertStatus($userIsRequester ? 302 : 403);
        $this->delete(action('App\TicketController@destroyWatcher', [$ticket, $reportingUser->id]))->assertStatus($userIsRequester ? 302 : 403);
        $this->post(action('App\TicketController@createTicketTag', $ticket), ['ticket_tags' => [TicketTag::inRandomOrder()->first()->id]])->assertStatus(403);
        $ticketTag = TicketTag::factory()->create();
        $this->delete(action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $ticket = Ticket::inRandomOrder()->first();
        $ticketCommentAttachment = TicketCommentAttachment::inRandomOrder()->first();

        $this->actingAs($regularUser);

        $this->get(action('App\TicketController@index'))->assertStatus(403);
        $this->get(action('App\TicketController@create'))->assertStatus(403);
        $this->get(action('App\TicketController@downloadAttachment', $ticketCommentAttachment))->assertStatus(403);
        $ticketData = Ticket::factory()->make()->toArray();
        $this->post(action('App\TicketController@store'), $ticketData)->assertStatus(403);
        $this->get(action('App\TicketController@show', $ticket))->assertStatus(403);
        $this->get(action('App\TicketController@edit', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@update', $ticket), [])->assertStatus(403);
        $this->post(action('App\TicketController@reply', $ticket), [])->assertStatus(403);
        $this->post(action('App\TicketController@remindRequester', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@markAsSolved', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@createWatcher', $ticket), [])->assertStatus(403);
        $this->delete(action('App\TicketController@destroyWatcher', [$ticket, $regularUser->id]))->assertStatus(403);
        $this->post(action('App\TicketController@createTicketTag', $ticket), ['ticket_tags' => [TicketTag::inRandomOrder()->first()->id]])->assertStatus(403);
        $ticketTag = TicketTag::factory()->create();
        $this->delete(action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $ticket = Ticket::inRandomOrder()->first();
        $ticketCommentAttachment = TicketCommentAttachment::inRandomOrder()->first();

        $this->actingAs($developer);

        $this->get(action('App\TicketController@index'))->assertStatus(403);
        $this->get(action('App\TicketController@create'))->assertStatus(403);
        $this->get(action('App\TicketController@downloadAttachment', $ticketCommentAttachment))->assertStatus(403);
        $ticketData = Ticket::factory()->make()->toArray();
        $this->post(action('App\TicketController@store'), $ticketData)->assertStatus(403);
        $this->get(action('App\TicketController@show', $ticket))->assertStatus(403);
        $this->get(action('App\TicketController@edit', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@update', $ticket), [])->assertStatus(403);
        $this->post(action('App\TicketController@reply', $ticket), [])->assertStatus(403);
        $this->post(action('App\TicketController@remindRequester', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@markAsSolved', $ticket))->assertStatus(403);
        $this->post(action('App\TicketController@createWatcher', $ticket), [])->assertStatus(403);
        $this->delete(action('App\TicketController@destroyWatcher', [$ticket, $developer->id]))->assertStatus(403);
        $this->post(action('App\TicketController@createTicketTag', $ticket), ['ticket_tags' => [TicketTag::inRandomOrder()->first()->id]])->assertStatus(403);
        $ticketTag = TicketTag::factory()->create();
        $this->delete(action('App\TicketController@destroyTicketTag', [$ticket, $ticketTag]))->assertStatus(403);
    }
}
