<?php

namespace App\Helpers;

use App\Models\TmsInstance;
use Illuminate\Support\Facades\Http;

class TmsHelper
{
    /**
     * Get TMS instance given statistic data prepared for charts.
     *
     * @param TmsInstance $tmsInstance
     *
     * @throws \Illuminate\Http\Client\RequestException
     *
     * @return array
     */
    public static function getChartsData(TmsInstance $tmsInstance): array
    {
        $baseUrl = $tmsInstance->base_url;
        $bearerToken = $tmsInstance->bearer_token;

        $response = Http::withToken($bearerToken)
            ->get($baseUrl . '/api/v3/statistics/charts');

        $response->throw();

        return $response->json();
    }
}
