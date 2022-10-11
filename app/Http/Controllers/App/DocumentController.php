<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User    $user
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'document' => 'required|file',
        ]);

        $this->authorize('create', Document::class);

        $file = $request->file('document');

        $filename = Storage::disk('s3')->putFile('documents', $file);

        Document::create([
            'user_id'     => $user->id,
            'uploaded_by' => $request->user()->id,
            'title'       => $file->getClientOriginalName(),
            'filename'    => $filename,
        ]);

        return redirect()->action('App\UserController@show', $user)
            ->with('success', __('The Document was successfully downloaded.'));
    }

    /**
     * @param Request  $request
     * @param Document $document
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return mixed
     */
    public function view(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        if (!Storage::disk('s3')->has($document->filename)) {
            abort(404);
        }

        $fileFromStorage = Storage::disk('s3')->get($document->filename);
        $mimeType = Storage::disk('s3')->mimeType($document->filename);

        return response()->make($fileFromStorage, 200)
            ->header('Content-Type', $mimeType);
    }

    /**
     * @param Request  $request
     * @param Document $document
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @return mixed
     */
    public function download(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        if (!Storage::disk('s3')->has($document->filename)) {
            abort(404);
        }

        return Storage::disk('s3')->download($document->filename, Str::ASCII($document->title));
    }
}
