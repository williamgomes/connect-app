<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Network\NetworkCreateRequest;
use App\Http\Requests\App\Network\NetworkUpdateRequest;
use App\Models\Datacenter;
use App\Models\Inventory;
use App\Models\IpAddress;
use App\Models\Network;
use Illuminate\Http\Request;
use IPv4\SubnetCalculator;

class NetworkController extends Controller
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
        $this->authorize('viewAny', Network::class);

        $networkQuery = Network::query();

        if ($request->has('search')) {
            $networkQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('ip_address', 'LIKE', '%' . $request->search . '%')
                ->orWhere('cidr', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.networks.index')->with([
            'networks' => $networkQuery->paginate(25),
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
        $this->authorize('create', Network::class);

        return view('app.networks.create')->with([
            'datacenters' => Datacenter::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NetworkCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NetworkCreateRequest $request)
    {
        $this->authorize('create', Network::class);

        Network::create(array_merge($request->only([
            'name',
            'ip_address',
            'cidr',
            'vlan_id',
        ]), [
            'x_data' => $request->only('datacenters'),
        ]));

        return redirect()->action('App\NetworkController@index')
            ->with('success', __('The Network was successfully created.'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Network $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Network $network)
    {
        $this->authorize('view', $network);

        return view('app.networks.show')->with([
            'network' => $network,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Network $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Network $network)
    {
        $this->authorize('update', $network);

        return view('app.networks.edit')->with([
            'network'     => $network,
            'datacenters' => Datacenter::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NetworkUpdateRequest $request
     * @param \App\Models\Network  $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NetworkUpdateRequest $request, Network $network)
    {
        $this->authorize('update', $network);

        $network->update(array_merge($request->only([
            'name',
            'ip_address',
            'cidr',
            'vlan_id',
        ]), [
            'x_data' => $request->only('datacenters'),
        ]));

        return redirect()->action('App\NetworkController@index')
            ->with('success', __('The Network was successfully updated.'));
    }

    /**
     * @param Network $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Network $network)
    {
        $this->authorize('delete', $network);

        $network->delete();

        return redirect()->action('App\NetworkController@index')
            ->with('info', __('The Network was successfully deleted.'));
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
    public function createIpAddress(Network $network)
    {
        $this->authorize('create', IpAddress::class);

        $subnetCalculator = new SubnetCalculator($network->ip_address, $network->cidr);

        $availableIpAddresses = [];
        foreach ($subnetCalculator->getAllHostIPAddresses() as $ipAddress) {
            $exists = IpAddress::where('address', $ipAddress)->exists();
            if (!$exists) {
                $availableIpAddresses[] = $ipAddress;
            }
        }

        return view('app.networks.ip-addresses.create')->with([
            'network'              => $network,
            'inventories'          => Inventory::all(),
            'availableIpAddresses' => $availableIpAddresses,
        ]);
    }
}
