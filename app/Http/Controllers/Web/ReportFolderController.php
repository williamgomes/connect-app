<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ReportFolder;
use App\Models\User;
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
        $reportFolders = User::getAvailableReportFolders($request->user());

        return view('web.reports.folders.index')->with([
            'reportFolders' => $reportFolders,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request      $request
     * @param ReportFolder $reportFolder
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, ReportFolder $reportFolder)
    {
        $reports = $reportFolder->reports()->orderBy('title')->get();
        $reportFolders = User::getAvailableReportFolders($request->user(), $reportFolder);

        return view('web.reports.folders.show')->with([
            'reportFolder'  => $reportFolder,
            'reportFolders' => $reportFolders,
            'reports'       => $reports,
        ]);
    }
}
