<form id="logout-form" action="{{ url('/logout') }}" method="POST" hidden>
    @csrf
</form>

<div class="dropdown">
    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="line-height: 30px">
        <i class="fe fe-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        @if(auth()->user()->hasRole(\App\Models\User::ROLE_REPORTING) || auth()->user()->hasRole(\App\Models\User::ROLE_AGENT) || auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN))
            <a class="dropdown-item" href="{{ action('App\DashboardController@show') }}">
                {{ __('Dashboard') }}
            </a>
        @endif
        @if((auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN) && \App\Models\Report::count()) || auth()->user()->reports->count())
            <a class="dropdown-item" href="{{ action('Web\ReportFolderController@index') }}">
                {{ __('Reports')}}
            </a>
        @endif
        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout')}}
        </a>
    </div>
</div>