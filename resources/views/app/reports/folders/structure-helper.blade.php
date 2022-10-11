@foreach($subfolders->sortBy('name') as $subfolder)
    <option value="{{ $subfolder->id }}" {{ (old('folder_id', $selected ?? ($report->folder->id ?? null)) == $subfolder->id) ? ' selected' : '' }}>{{ $subfolder->fullPath() }}</option>
    @if($allFolders->where('parent_id', $subfolder->id)->count())
        @include('app.reports.folders.structure-helper', ['subfolders' => $allFolders->sortBy('name')->where('parent_id', $subfolder->id)])
    @endif
@endforeach