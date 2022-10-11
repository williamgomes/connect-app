<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ProvisionScript;
use App\Models\ProvisionScriptLog;
use IPv4\SubnetCalculator;

class ProvisionScriptController extends Controller
{
    /**
     * Show the specified resource.
     *
     * @param \App\Models\ProvisionScript $provisionScript
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function show($uuid, ProvisionScript $provisionScript)
    {
        $inventory = Inventory::where('uuid', $uuid)->first();

        $provisionScript = $inventory->provisionScripts()->find($provisionScript->id);

        if (!$provisionScript) {
            abort(404);
        }

        $content = $provisionScript->pivot->content;

        $primaryIp = $inventory->ipAddresses()->primary()->first();

        if ($primaryIp) {
            $subnetCalculator = new SubnetCalculator($primaryIp->address, $primaryIp->network->cidr);
            $primarySubnet = $subnetCalculator->getSubnetMask();
        }

        $variables = [
            'identifier'             => $inventory->identifier,
            'hostname'               => $inventory->hostname,
            'primary_ip'             => $primaryIp ? $primaryIp->address : null,
            'primary_ip_with_subnet' => $primaryIp ? $primaryIp->address . '/' . $primaryIp->network->cidr : null,
            'primary_subnet'         => $primarySubnet ?? null,
            'primary_gateway'        => $primaryIp ? $primaryIp->network->gateway : null,
            'note'                   => $inventory->note,
        ];

        foreach ($variables as $key => $value) {
            if (!is_null($value)) {
                $content = str_replace('[[' . $key . ']]', $value, $content);
            }
        }

        ProvisionScriptLog::create([
            'provision_script_id' => $provisionScript->id,
            'inventory_id'        => $inventory->id,
            'content'             => $content,
        ]);

        return response($content)->header('Content-Type', 'text/plain');
    }
}
