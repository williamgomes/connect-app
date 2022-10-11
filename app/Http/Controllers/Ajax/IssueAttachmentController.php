<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\IssueAttachment;
use Illuminate\Http\Request;

class IssueAttachmentController extends Controller
{
    /**
     * @param Request         $request
     * @param IssueAttachment $issueAttachment
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, IssueAttachment $issueAttachment)
    {
        $this->authorize('update', $issueAttachment->issue);

        $issueAttachment->delete();

        return response()->json(['success' => true]);
    }
}
