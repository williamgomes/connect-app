<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\IpAddress\IpAddressCreateRequest;
use App\Http\Requests\App\IpAddress\IpAddressUpdateRequest;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IpAddressController extends Controller
{
    /**
     * Store the specific model resource.
     *
     * @param \App\Models\Network $network
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IpAddressCreateRequest $request)
    {
        $this->authorize('create', IpAddress::class);

        $ipAddress = IpAddress::where('address', $request->input('address'))->first();
        if ($ipAddress) {
            throw ValidationException::withMessages(['The IP address (' . $ipAddress->address . ') is already used.']);
        }

        $ipAddress = IpAddress::create($request->only([
            'network_id',
            'inventory_id',
            'address',
            'primary',
            'description',
        ]));

        if ($request->input('ref') == 'inventory' && $ipAddress->inventory) {
            return redirect()->action('App\InventoryController@show', $ipAddress->inventory)
                ->with('success', 'The IP Address was successfully added.');
        }

        return redirect()->action('App\NetworkController@show', $ipAddress->network)
            ->with('success', 'The IP Address was successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request   $request
     * @param IpAddress $ipAddress
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, IpAddress $ipAddress)
    {
        $this->authorize('update', $ipAddress);

        return view('app.ip-addresses.edit')->with([
            'ipAddress' => $ipAddress,
            'ref'       => $request->input('ref'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IpAddressUpdateRequest $request
     * @param \App\Models\IpAddress  $ipAddress
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IpAddressUpdateRequest $request, IpAddress $ipAddress)
    {
        $this->authorize('update', $ipAddress);

        $ipAddress->update($request->only([
            'primary',
            'description',
        ]));

        if ($request->input('ref') == 'inventory' && $ipAddress->inventory) {
            return redirect()->action('App\InventoryController@show', $ipAddress->inventory)
                ->with('success', __('The IP Address was successfully updated.'));
        }

        return redirect()->action('App\NetworkController@show', $ipAddress->network)
            ->with('success', __('The IP Address was successfully updated.'));
    }

    /**
     * @param Request   $request
     * @param IpAddress $ipAddress
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, IpAddress $ipAddress)
    {
        $this->authorize('delete', $ipAddress);

        $ipAddress->delete();

        if ($request->input('ref') == 'inventory' && $ipAddress->inventory) {
            return redirect()->action('App\InventoryController@show', $ipAddress->inventory)
                ->with('info', __('The IP Address was successfully removed.'));
        }

        return redirect()->action('App\NetworkController@show', $ipAddress->network)
            ->with('info', __('The IP Address was successfully removed.'));
    }
}
