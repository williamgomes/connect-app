<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ReportHelper;
use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Show the specified resource.
     *
     * @param \App\Models\Report $report
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $iframeUrl = ReportHelper::getMetabaseIframeUrl($report);

        return view('web.reports.show')->with([
            'report'    => $report,
            'iframeUrl' => $iframeUrl,
        ]);
    }
}
