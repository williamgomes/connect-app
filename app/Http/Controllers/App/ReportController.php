<?php

namespace App\Http\Controllers\App;

use App\Helpers\ReportHelper;
use App\Helpers\TmsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Report\ReportCreateRequest;
use App\Http\Requests\App\Report\ReportUpdateRequest;
use App\Http\Requests\App\ReportBudget\ReportBudgetUpdateRequest;
use App\Models\Report;
use App\Models\ReportBudget;
use App\Models\ReportFolder;
use App\Models\TmsInstance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);

        $reportQuery = Report::query();

        if ($request->has('search')) {
            $reportQuery->where('title', 'LIKE', '%' . $request->search . '%')
                ->where('description', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.reports.index')->with([
            'reports' => $reportQuery->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Report::class);
        $reportFolders = ReportFolder::root()->get();

        return view('app.reports.create')->with([
            'users'         => User::all(),
            'reportFolders' => $reportFolders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReportCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReportCreateRequest $request)
    {
        $this->authorize('create', Report::class);

        Report::create(array_merge($request->only(['folder_id', 'metabase_id', 'title', 'description']), [
            'user_id' => $request->user()->id,
            'x_data'  => [
                'users' => $request->input('users') ?? [],
            ],
        ]));

        return redirect()->action('App\ReportController@index')
            ->with('success', __('The Report was successfully created.'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Report $report
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Report $report)
    {
        $this->authorize('view', $report);

        if (!$request->user()->hasRole(User::ROLE_ADMIN)) {
            return redirect()->action('Web\ReportController@show', $report);
        }

        $iframeUrl = ReportHelper::getMetabaseIframeUrl($report);

        return view('app.reports.show')->with([
            'report'    => $report,
            'iframeUrl' => $iframeUrl,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Report $report
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Report $report)
    {
        $this->authorize('update', $report);

        $reportFolders = ReportFolder::orderBy('name')->get();

        return view('app.reports.edit')->with([
            'users'         => User::all(),
            'report'        => $report,
            'reportFolders' => $reportFolders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReportUpdateRequest $request
     * @param \App\Models\Report  $report
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReportUpdateRequest $request, Report $report)
    {
        $this->authorize('update', $report);

        $report->update(array_merge($request->only(['folder_id', 'title', 'description']), [
            'x_data' => [
                'users' => $request->input('users') ?? [],
            ],
        ]));

        return redirect()->action('App\ReportController@index')
            ->with('success', __('The Report was successfully updated.'));
    }

    /**
     * @param Report $report
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        $report->delete();

        return redirect()->action('App\ReportController@index')
            ->with('info', __('The Report was successfully deleted.'));
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function tmsInstances(Request $request)
    {
        $this->authorize('viewAnyReport', TmsInstance::class);

        $tmsInstances = TmsInstance::query();

        if ($request->has('search')) {
            $tmsInstances->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('identifier', 'LIKE', '%' . $request->search . '%');
        }

        return view('app.reports.tms-instances.index')->with([
            'tmsInstances' => $tmsInstances->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showTmsInstance(Request $request, TmsInstance $tmsInstance)
    {
        $this->authorize('viewReport', $tmsInstance);

        $tmsInstances = TmsInstance::all();

        $data = TmsHelper::getChartsData($tmsInstance);

        return view('app.reports.tms-instances.show')->with([
            'tmsInstances'        => $tmsInstances,
            'selectedTmsInstance' => $tmsInstance,
            'labels'              => $data['labels'],
            'data'                => $data['data'],
        ]);
    }

    /**
     * @param Request     $request
     * @param TmsInstance $tmsInstance
     * @param string      $type
     * @param string      $period
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function editBudget(Request $request, TmsInstance $tmsInstance, string $type, string $period)
    {
        $this->authorize('updateBudget', $tmsInstance);

        if (!in_array($type, array_keys(TmsInstance::$types))) {
            abort(404);
        }

        if (!in_array($period, [TmsInstance::PERIOD_DAY, TmsInstance::PERIOD_MONTH, TmsInstance::PERIOD_YEAR])) {
            abort(404);
        }

        if ($period == TmsInstance::PERIOD_DAY) {
            $range = CarbonPeriod::create(Carbon::now()->subMonthNoOverflow(), Carbon::now()->subDay());
            $labelFormat = 'D d.m.y';
            $keyFormat = 'Y-m-d';
        } elseif ($period == TmsInstance::PERIOD_MONTH) {
            $range = CarbonPeriod::create(Carbon::now()->subMonthsNoOverflow(11)->startOfMonth(), '1 month', Carbon::now()->endOfMonth());
            $labelFormat = 'F';
            $keyFormat = 'Y-m';
        } elseif ($period == TmsInstance::PERIOD_YEAR) {
            $range = CarbonPeriod::create(Carbon::now()->subYearsNoOverflow(2)->startOfYear(), '1 year', Carbon::now()->endOfYear());
            $labelFormat = $keyFormat = 'Y';
        }

        $dates = [];
        foreach ($range as $date) {
            $dates[] = [
                'label' => $date->format($labelFormat),
                'key'   => $date->format($keyFormat),
            ];
        }

        $reportBudget = ReportBudget::where([
            'tms_instance_id' => $tmsInstance->id,
            'type'            => $type,
            'period'          => $period,
        ])->first();

        $values = $reportBudget->values ?? [];

        return view('app.reports.tms-instances.edit-budget')->with([
            'tmsInstance' => $tmsInstance,
            'type'        => $type,
            'period'      => $period,
            'dates'       => $dates,
            'values'      => $values,
        ]);
    }

    /**
     * @param ReportBudgetUpdateRequest $request
     * @param TmsInstance               $tmsInstance
     * @param string                    $type
     * @param string                    $period
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBudget(ReportBudgetUpdateRequest $request, TmsInstance $tmsInstance, string $type, string $period)
    {
        $this->authorize('updateBudget', $tmsInstance);

        $reportBudget = ReportBudget::updateOrCreate([
            'tms_instance_id' => $tmsInstance->id,
            'type'            => $type,
            'period'          => $period,
        ], [
            'values' => $request->input('budget_values'),
        ]);

        return redirect()->action('App\ReportController@showTmsInstance', $tmsInstance)
            ->with('success', __('The budgeted values were successfully updated.'));
    }
}
