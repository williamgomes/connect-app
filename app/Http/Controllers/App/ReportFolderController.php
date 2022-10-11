<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ReportFolder\ReportFolderCreateRequest;
use App\Http\Requests\App\ReportFolder\ReportFolderUpdateRequest;
use App\Models\ReportFolder;
use Illuminate\Http\Request;

class ReportFolderController extends Controller
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
        $this->authorize('viewAny', ReportFolder::class);

        $reportFolderQuery = ReportFolder::root();

        if ($request->has('search')) {
            $reportFolderQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('parentFolder', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.reports.folders.index')->with([
            'reportFolders' => $reportFolderQuery->paginate(25),
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
        $this->authorize('create', ReportFolder::class);

        $parentReportFolders = ReportFolder::orderBy('name')->get();

        return view('app.reports.folders.create')->with([
            'parentReportFolders' => $parentReportFolders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReportFolderCreateRequest $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ReportFolderCreateRequest $request)
    {
        $this->authorize('create', ReportFolder::class);

        $reportFolder = ReportFolder::create(array_merge($request->only(['name', 'parent_id']), [
            'user_id' => $request->user()->id,
        ]));

        return redirect()->action('App\ReportFolderController@show', $reportFolder)
            ->with('success', __('The Report Folder was successfully created.'));
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\ReportFolder $reportFolder
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, ReportFolder $reportFolder)
    {
        $this->authorize('update', $reportFolder);

        $reportFolderQuery = $reportFolder->subfolders();

        if ($request->filled('search')) {
            $reportFolderQuery->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
                });
        }

        return view('app.reports.folders.show')->with([
            'currentReportFolder' => $reportFolder,
            'reportFolders'       => $reportFolderQuery->paginate(25),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ReportFolder $reportFolder
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(ReportFolder $reportFolder)
    {
        $this->authorize('update', $reportFolder);

        $parentReportFolders = ReportFolder::orderBy('name')
            ->where('id', '!=', $reportFolder->id)
            ->whereNotIn('id', $reportFolder->subfolders()->pluck('id'))
            ->get();

        return view('app.reports.folders.edit')->with([
            'parentReportFolders' => $parentReportFolders,
            'reportFolder'        => $reportFolder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReportFolderUpdateRequest $request
     * @param \App\Models\ReportFolder  $reportFolder
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReportFolderUpdateRequest $request, ReportFolder $reportFolder)
    {
        $this->authorize('update', $reportFolder);

        $reportFolder->update($request->only(['name', 'parent_id']));

        return redirect()->action('App\ReportFolderController@show', $reportFolder)
            ->with('success', __('The Report Folder was successfully updated.'));
    }

    /**
     * @param ReportFolder $reportFolder
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ReportFolder $reportFolder)
    {
        $this->authorize('delete', $reportFolder);

        $reportFolder->delete();

        if ($reportFolder->parentFolder) {
            return redirect()->action('App\ReportFolderController@show', $reportFolder->parentFolder)
                ->with('info', __('The Report Folder was successfully deleted.'));
        }

        return redirect()->action('App\ReportFolderController@index')
            ->with('info', __('The Report Folder was successfully deleted.'));
    }
}
