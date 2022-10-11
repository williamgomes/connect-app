<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ action('HomeController@index') }}">
            <img src="{{ asset('web/images//logo/synega-connect.png') }}" class="navbar-brand-img" alt="{{ env('COMPANY_NAME' ) . ' ' . __('Logo') }}">
        </a>

        @auth
            {{-- Toggler --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Collapsing Navigation --}}
            <div class="collapse navbar-collapse" id="navbarCollapse">
                {{-- Navigation Toggle --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-x"></i>
                </button>

                {{-- Main Navigation --}}
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('blog*') ? 'active' : '' }}" href="{{ action('Web\BlogController@index') }}">
                            {{ __('Our Blog')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('help-center*') ? 'active' : '' }}" href="{{ action('Web\HelpCenterController@index') }}">
                            {{ __('Help Center')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('faq*') ? 'active' : '' }}" href="{{ action('Web\FaqCategoryController@index') }}">
                            {{ __('FAQ')}}
                        </a>
                    </li>
                    @can('viewAnyPersonal', \App\Models\Ticket::class)
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('tickets*') ? 'active' : '' }}" href="{{ action('Web\TicketController@index', 'open') }}">
                                {{ __('Your tickets')}}
                                @php
                                    $openTicketCount = auth()->user()
                                        ->tickets()
                                        ->where('status', \App\Models\Ticket::STATUS_OPEN)
                                        ->count();
                                @endphp
                                @if ($openTicketCount)
                                    <span class="badge badge-danger badge-pill">{{ $openTicketCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('issues*') ? 'active' : '' }}" href="{{ action('Web\IssueController@index') }}">
                            {{ __('Issues')}}
                        </a>
                    </li>
                    @can('viewEmails', auth()->user())
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('emails*') ? 'active' : '' }}" href="{{ action('Web\UserEmailController@index') }}">
                                {{ __('Emails')}}
                            </a>
                        </li>
                    @endcan
                    <li class="ml-2 pr-2 my-2 d-none d-lg-block">
                        @include('web.layouts.topnavbar-min-menu')
                    </li>
                    @if(auth()->user()->hasRole(\App\Models\User::ROLE_REPORTING) || auth()->user()->hasRole(\App\Models\User::ROLE_AGENT) || auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN) || Auth::user()->permissions()->count())
                        <li class="nav-item d-lg-none d-block">
                            <a class="nav-link text-success" href="{{ action('App\DashboardController@show') }}">
                                {{ __('Dashboard')}}
                            </a>
                        </li>
                    @endif

                    @if((auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN) && \App\Models\Report::count()) || auth()->user()->reports->count())
                        <li class="nav-item d-lg-none d-block">
                            <a class="nav-link {{ Request::is('report-folders*') ? 'active' : '' }}" href="{{ action('Web\ReportFolderController@index') }}">
                                {{ __('Reports')}}
                            </a>
                        </li>
                    @endif
                    <li class="nav-item d-lg-none d-block">
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" hidden>
                            @csrf
                        </form>
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout')}}
                        </a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
