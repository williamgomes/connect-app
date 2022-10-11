<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <form>
                    <div class="row align-items-center">
                        <div class="col-auto pr-0">
                            <span class="fe fe-search text-muted"></span>
                        </div>
                        <div class="col">
                            <input type="text" name="search" class="form-control form-control-flush" value="{{ app('request')->input('search') }}" placeholder="{{ __('Search') }}" autofocus>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-nowrap card-table">
            <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Creator') }}</th>
                <th class="text-right">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="list">
            @foreach($reportFolders as  $reportFolder)
                <tr>
                    <td class="report-folder-name">
                        @can('update',  $reportFolder)
                            <a href="{{ action('App\ReportFolderController@show',  $reportFolder) }}">
                                {{ $reportFolder->name }}
                            </a>
                        @else
                            {{ $reportFolder->name }}
                        @endcan
                    </td>
                    <td class="report-folder-user">
                        <a href="{{ action('App\UserController@show', $reportFolder->user) }}">{{ $reportFolder->user->name }}</a>
                    </td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @can('update',  $reportFolder)
                                    <a href="{{ action('App\ReportFolderController@edit', $reportFolder) }}" class="dropdown-item">
                                        {{ __('Edit') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center">
        {{ $reportFolders->appends(request()->query())->links() }}
    </div>
</div>