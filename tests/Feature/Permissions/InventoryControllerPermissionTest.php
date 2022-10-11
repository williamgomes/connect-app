<?php

namespace Tests\Feature\Permissions;

use App\Models\Guide;
use App\Models\Inventory;
use App\Models\Network;
use App\Models\ProvisionScript;
use App\Models\User;
use Tests\TestCase;

class InventoryControllerPermissionTest extends TestCase
{
    public function test_permission_for_admin_user()
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $inventory = Inventory::inRandomOrder()->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($admin);

        $this->get(action('App\InventoryController@index'))->assertStatus(200);
        $this->get(action('App\InventoryController@create'))->assertStatus(200);
        $inventoryData = Inventory::factory()->make()->toArray();
        $this->post(action('App\InventoryController@store'), $inventoryData)->assertRedirectContains(action('App\InventoryController@index'));
        $this->get(action('App\InventoryController@show', $inventory))->assertStatus(200);
        $this->get(action('App\InventoryController@edit', $inventory))->assertStatus(200);
        $this->post(action('App\InventoryController@update', $inventory))->assertValid()->assertRedirect(action('App\InventoryController@index'));
        $this->get(action('App\InventoryController@createIpAddress', [$inventory, 'network_id' => Network::inRandomOrder()->first()->id]))->assertStatus(200);

        // Inventory Provision Scripts
        $this->get(action('App\InventoryController@createProvisionScript', $inventory))->assertStatus(200);
        $this->post(action('App\InventoryController@storeProvisionScript', $inventory), ['provision_script_id' => $provisionScript->id])->assertValid()->assertRedirect(action('App\InventoryController@show', $inventory));
        $this->get(action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]))->assertStatus(200);
        $this->post(action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]), ['content' => 'test'])->assertValid()->assertRedirect(action('App\InventoryController@show', $inventory));
        $this->delete(action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]))->assertRedirect(action('App\InventoryController@show', $inventory));

        // Inventory Guides
        $this->get(action('App\InventoryController@addGuide', $inventory))->assertStatus(200);
        $this->post(action('App\InventoryController@storeGuide', $inventory), ['guide_id' => $guide->id])->assertValid()->assertRedirect(action('App\InventoryController@show', $inventory));
        $this->delete(action('App\InventoryController@destroyGuide', [$inventory, $guide]))->assertRedirect(action('App\InventoryController@show', $inventory));

        $this->delete(action('App\InventoryController@destroy', $inventory))->assertRedirect(action('App\InventoryController@index'));
    }

    public function test_permission_for_agent_user()
    {
        $agent = User::where('role', User::ROLE_AGENT)->first();
        $inventory = Inventory::inRandomOrder()->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($agent);
        $this->get(action('App\InventoryController@index'))->assertStatus(403);
        $this->get(action('App\InventoryController@create'))->assertStatus(403);
        $inventoryData = Inventory::factory()->make()->toArray();
        $this->post(action('App\InventoryController@store'), $inventoryData)->assertStatus(403);
        $this->get(action('App\InventoryController@show', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@edit', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@update', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@createIpAddress', [$inventory, 'network_id' => Network::inRandomOrder()->first()->id]))->assertStatus(403);

        // Inventory Provision Scripts
        $this->get(action('App\InventoryController@createProvisionScript', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeProvisionScript', $inventory), ['provision_script_id' => $provisionScript->id])->assertStatus(403);
        $this->get(action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);
        $this->post(action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]), ['content' => 'test'])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);

        // Inventory Guides
        $this->get(action('App\InventoryController@addGuide', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeGuide', $inventory), ['guide_id' => $guide->id])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyGuide', [$inventory, $guide]))->assertStatus(403);

        $this->delete(action('App\InventoryController@destroy', $inventory))->assertStatus(403);
    }

    public function test_permission_for_reporting_user()
    {
        $reportingUser = User::where('role', User::ROLE_REPORTING)->first();
        $inventory = Inventory::inRandomOrder()->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($reportingUser);

        $this->get(action('App\InventoryController@index'))->assertStatus(403);
        $this->get(action('App\InventoryController@create'))->assertStatus(403);
        $inventoryData = Inventory::factory()->make()->toArray();
        $this->post(action('App\InventoryController@store'), $inventoryData)->assertStatus(403);
        $this->get(action('App\InventoryController@show', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@edit', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@update', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@createIpAddress', [$inventory, 'network_id' => Network::inRandomOrder()->first()->id]))->assertStatus(403);

        // Inventory Provision Scripts
        $this->get(action('App\InventoryController@createProvisionScript', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeProvisionScript', $inventory), ['provision_script_id' => $provisionScript->id])->assertStatus(403);
        $this->get(action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);
        $this->post(action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]), ['content' => 'test'])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);

        // Inventory Guides
        $this->get(action('App\InventoryController@addGuide', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeGuide', $inventory), ['guide_id' => $guide->id])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyGuide', [$inventory, $guide]))->assertStatus(403);

        $this->delete(action('App\InventoryController@destroy', $inventory))->assertStatus(403);
    }

    public function test_permission_for_regular_user()
    {
        $regularUser = User::where('role', User::ROLE_REGULAR)->first();
        $inventory = Inventory::inRandomOrder()->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($regularUser);
        $this->get(action('App\InventoryController@index'))->assertStatus(403);
        $this->get(action('App\InventoryController@create'))->assertStatus(403);
        $inventoryData = Inventory::factory()->make()->toArray();
        $this->post(action('App\InventoryController@store'), $inventoryData)->assertStatus(403);
        $this->get(action('App\InventoryController@show', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@edit', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@update', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@createIpAddress', [$inventory, 'network_id' => Network::inRandomOrder()->first()->id]))->assertStatus(403);

        // Inventory Provision Scripts
        $this->get(action('App\InventoryController@createProvisionScript', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeProvisionScript', $inventory), ['provision_script_id' => $provisionScript->id])->assertStatus(403);
        $this->get(action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);
        $this->post(action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]), ['content' => 'test'])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);

        // Inventory Guides
        $this->get(action('App\InventoryController@addGuide', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeGuide', $inventory), ['guide_id' => $guide->id])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyGuide', [$inventory, $guide]))->assertStatus(403);

        $this->delete(action('App\InventoryController@destroy', $inventory))->assertStatus(403);
    }

    public function test_permission_for_developer_user()
    {
        $developer = User::where('role', User::ROLE_DEVELOPER)->first();
        $inventory = Inventory::inRandomOrder()->first();
        $provisionScript = ProvisionScript::inRandomOrder()->first();
        $guide = Guide::inRandomOrder()->first();

        $this->actingAs($developer);
        $this->get(action('App\InventoryController@index'))->assertStatus(403);
        $this->get(action('App\InventoryController@create'))->assertStatus(403);
        $inventoryData = Inventory::factory()->make()->toArray();
        $this->post(action('App\InventoryController@store'), $inventoryData)->assertStatus(403);
        $this->get(action('App\InventoryController@show', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@edit', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@update', $inventory))->assertStatus(403);
        $this->get(action('App\InventoryController@createIpAddress', [$inventory, 'network_id' => Network::inRandomOrder()->first()->id]))->assertStatus(403);

        // Inventory Provision Scripts
        $this->get(action('App\InventoryController@createProvisionScript', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeProvisionScript', $inventory), ['provision_script_id' => $provisionScript->id])->assertStatus(403);
        $this->get(action('App\InventoryController@editProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);
        $this->post(action('App\InventoryController@updateProvisionScript', [$inventory, $provisionScript]), ['content' => 'test'])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyProvisionScript', [$inventory, $provisionScript]))->assertStatus(403);

        // Inventory Guides
        $this->get(action('App\InventoryController@addGuide', $inventory))->assertStatus(403);
        $this->post(action('App\InventoryController@storeGuide', $inventory), ['guide_id' => $guide->id])->assertStatus(403);
        $this->delete(action('App\InventoryController@destroyGuide', [$inventory, $guide]))->assertStatus(403);

        $this->delete(action('App\InventoryController@destroy', $inventory))->assertStatus(403);
    }
}
