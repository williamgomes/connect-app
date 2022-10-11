<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ReportBudget;
use App\Models\TmsInstance;
use Illuminate\Http\Request;

class ReportBudgetController extends Controller
{
    /**
     * @param Request $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $period = $request->input('period');
        $tmsInstanceId = $request->input('tms_instance_id');
        $type = $request->input('type');

        $tmsInstance = TmsInstance::find($tmsInstanceId);

        if (!$tmsInstance) {
            return response()->json([
                'data' => [],
            ]);
        }

        $this->authorize('viewReport', $tmsInstance);

        $reportBudget = ReportBudget::where([
            'tms_instance_id' => $tmsInstanceId,
            'type'            => $type,
            'period'          => $period,
        ])->first();

        $values = $reportBudget->values ?? [];

        return response()->json([
            'data' => $values,
        ]);
    }
}
