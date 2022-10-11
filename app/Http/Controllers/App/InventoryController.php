<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Inventory\InventoryCreateRequest;
use App\Http\Requests\App\Inventory\InventoryUpdateRequest;
use App\Http\Requests\App\ProvisionScript\ProvisionScriptUpdateRequest;
use App\Models\Datacenter;
use App\Models\Guide;
use App\Models\Inventory;
use App\Models\IpAddress;
use App\Models\ItService;
use App\Models\Network;
use App\Models\ProvisionScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use IPv4\SubnetCalculator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Inventory::class);

        $inventoryQuery = Inventory::with(['itService', 'datacenter']);

        if ($request->has('search')) {
            $inventoryQuery->where('identifier', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.inventories.index')->with([
            'inventories' => $inventoryQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Inventory::class);

        return view('app.inventories.create')->with([
            'datacenters'      => Datacenter::all(),
            'itServices'       => ItService::all(),
            'provisionScripts' => ProvisionScript::all(),
            'guides'           => Guide::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InventoryCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryCreateRequest $request)
    {
        $this->authorize('create', Inventory::class);

        Inventory::create(array_merge($request->only(['type', 'status', 'identifier', 'datacenter_id', 'it_service_id', 'note']), [
            'x_data' => [
                'guides' => $request->input('guides') ?? [],
            ],
        ]));

        return redirect()->action('App\InventoryController@index')
            ->with('success', __('The Inventory was successfully created.'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        $this->authorize('view', $inventory);

        return view('app.inventories.show')->with([
            'inventory' => $inventory,
            'networks'  => Network::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Inventory $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        return view('app.inventories.edit')->with([
            'inventory'   => $inventory,
            'datacenters' => Datacenter::all(),
            'itServices'  => ItService::all(),
            'guides'      => Guide::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InventoryUpdateRequest $request
     * @param \App\Models\Inventory  $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryUpdateRequest $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $inventory->update(array_merge($request->only(['type', 'status', 'datacenter_id', 'it_service_id', 'note']), [
            'x_data' => [
                'guides' => $request->input('guides') ?? [],
            ],
        ]));

        return redirect()->action('App\InventoryController@index')
            ->with('success', __('The Inventory was successfully updated.'));
    }

    /**
     * @param Inventory $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inventory $inventory)
    {
        $this->authorize('delete', $inventory);

        $inventory->delete();

        return redirect()->action('App\InventoryController@index')
            ->with('info', __('The Inventory was successfully deleted.'));
    }

    /**
     * Show the form for adding IP address.
     *
     * @param \App\Models\Network $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createIpAddress(Request $request, Inventory $inventory)
    {
        $this->authorize('create', IpAddress::class);

        $request->validate([
            'network_id' => 'required|integer|exists:networks,id',
        ]);

        $network = Network::find($request->input('network_id'));

        $subnetCalculator = new SubnetCalculator($network->ip_address, $network->cidr);

        $availableIpAddresses = [];
        foreach ($subnetCalculator->getAllHostIPAddresses() as $ipAddress) {
            $exists = IpAddress::where('address', $ipAddress)->exists();
            if (!$exists) {
                $availableIpAddresses[] = $ipAddress;
            }
        }

        return view('app.inventories.ip-addresses.create')->with([
            'network'              => $network,
            'inventory'            => $inventory,
            'availableIpAddresses' => $availableIpAddresses,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function addGuide(Request $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $guides = Guide::whereNotIn('id', $inventory->guides()->pluck('guides.id'))->get();

        return view('app.inventories.guides.create')->with([
            'inventory' => $inventory,
            'guides'    => $guides,
        ]);
    }

    /**
     * Store a relationship in storage.
     *
     * @param Request   $request
     * @param Inventory $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function storeGuide(Request $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $request->validate([
            'guide_id' => 'required|integer|exists:guides,id',
        ]);

        $inventory->guides()->attach($request->input('guide_id'));

        return redirect()->action('App\InventoryController@show', $inventory)
            ->with('success', __('The Guide was successfully attached to the Inventory.'));
    }

    /**
     * @param Guide $guide
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyGuide(Inventory $inventory, Guide $guide)
    {
        $this->authorize('update', $inventory);

        $inventory->guides()->detach($guide->id);

        return redirect()->action('App\InventoryController@show', $inventory)
            ->with('info', __('The Guide was successfully detached from the Inventory.'));
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function createProvisionScript(Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        return view('app.inventories.provision-scripts.create')->with([
            'inventory'        => $inventory,
            'provisionScripts' => ProvisionScript::all(),
        ]);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param Request               $request
     * @param \App\Models\Inventory $inventory
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProvisionScript(Request $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $request->validate([
            'provision_script_id' => 'required|integer|exists:provision_scripts,id',
        ]);

        $provisionScript = ProvisionScript::find($request->input('provision_script_id'));

        $inventory->provisionScripts()->attach($provisionScript->id, [
            'content' => $provisionScript->content,
        ]);

        return redirect()->action('App\InventoryController@show', $inventory)
            ->with('success', __('The Provision Script was successfully added.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProvisionScript $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function editProvisionScript(Inventory $inventory, ProvisionScript $provisionScript)
    {
        $this->authorize('update', $inventory);

        $content = $inventory->provisionScripts()->find($provisionScript->id)->pivot->content;

        return view('app.inventories.provision-scripts.edit')->with([
            'inventory'       => $inventory,
            'provisionScript' => $provisionScript,
            'content'         => $content,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProvisionScriptUpdateRequest $request
     * @param \App\Models\ProvisionScript  $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProvisionScript(ProvisionScriptUpdateRequest $request, Inventory $inventory, ProvisionScript $provisionScript)
    {
        $this->authorize('update', $inventory);

        DB::table('inventory_provision_script')
            ->where([
                'inventory_id'        => $inventory->id,
                'provision_script_id' => $provisionScript->id,
            ])
            ->update($request->only([
                'content',
            ]));

        return redirect()->action('App\InventoryController@show', $inventory)
            ->with('success', __('The Provision Script was successfully updated.'));
    }

    /**
     * @param ProvisionScript $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyProvisionScript(Inventory $inventory, ProvisionScript $provisionScript)
    {
        $this->authorize('update', $inventory);

        $inventory->provisionScripts()->detach($provisionScript->id);

        return redirect()->action('App\InventoryController@show', $inventory)
            ->with('info', __('The Provision Script was successfully removed.'));
    }
}
