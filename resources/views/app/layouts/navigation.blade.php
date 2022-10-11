<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Logo --}}
        <a class="navbar-brand" href="#">
            <img src="{{ asset('app/images/logo/connect.png') }}" class="navbar-brand-img mx-auto" alt="{{ env('COMPANY_NAME' ) }} Logo">
        </a>

        <div class="collapse navbar-collapse" id="sidebarCollapse">
            <h6 class="navbar-heading text-muted">
                {{ __('Overview') }}
            </h6>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('app/dashboard') ? 'active' : '' }}" href="{{ action('App\DashboardController@show') }}">
                        <i class="fe fe-home"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                @can('viewAny', \App\Models\Ticket::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/tickets*') ? 'active' : '' }}" href="#sidebarTickets" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTickets">
                        <i class="fe fe-mail"></i> {{ __('Tickets') }}
                        </a>
                        <div class="collapse {{ Request::is('app/tickets*') ? 'show' : '' }}" id="sidebarTickets">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ action('App\TicketController@index') }}" class="nav-link {{ Request::is('app/tickets') ? 'active' : '' }}">
                                        <span class="text-dark mr-1">●</span> {{ __('All')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ action('App\TicketController@index', 'open') }}" class="nav-link {{ Request::is('app/tickets/open') ? 'active' : '' }}">
                                        <span class="text-primary mr-1">●</span> {{ __('Open')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ action('App\TicketController@index', 'solved') }}" class="nav-link {{ Request::is('app/tickets/solved') ? 'active' : '' }}">
                                        <span class="text-success mr-1">●</span>  {{ __('Solved')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ action('App\TicketController@index', 'closed') }}" class="nav-link {{ Request::is('app/tickets/closed') ? 'active' : '' }}">
                                        <span class="text-secondary mr-1">●</span> {{ __('Closed')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('viewAny', \App\Models\BlogPost::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/settings/blog-posts*') ? 'active' : '' }}" href="{{ action('App\BlogPostController@index') }}">
                            <i class="fe fe-bold"></i>{{ __('Blog Posts')}}
                        </a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\User::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/users*') ? 'active' : '' }}" href="{{ action('App\UserController@index') }}">
                            <i class="fe fe-user"></i> {{ __('Users')}}
                        </a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\Issue::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/issues*') ? 'active' : '' }}" href="{{ action('App\IssueController@index') }}">
                            <i class="fe fe-help-circle"></i> {{ __('Issues')}}
                        </a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\Application::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/applications*') ? 'active' : '' }}" href="{{ action('App\ApplicationController@index') }}">
                            <i class="fe fe-box"></i> {{ __('Applications')}}
                        </a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\Company::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/companies*') ? 'active' : '' }}" href="{{ action('App\CompanyController@index') }}">
                            <i class="fe fe-briefcase"></i> {{ __('Companies') }}
                        </a>
                    </li>
                @endcan

                @can('view-reports', Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarReports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarReports">
                            <i class="fe fe-bar-chart"></i> {{ __('Reports') }}
                        </a>
                        <div class="collapse {{ Request::is('app/reports/*') ? 'show' : '' }}" id="sidebarReports">
                            <ul class="nav nav-sm flex-column">
                                @can('viewAnyReport', \App\Models\TmsInstance::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/reports/tms-instances*') ? 'active' : '' }}" href="{{ action('App\ReportController@tmsInstances') }}">
                                            {{ __('TMS Instances') }}
                                        </a>
                                    </li>
                                @endcan
                                @foreach(\App\Models\Report::all() as $report)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/reports/' . $report->id) ? 'active' : '' }}" href="{{ action('App\ReportController@show', $report) }}">
                                            {{ $report->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarInfrastructure" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInfrastructure">
                        <i class="fe fe-server"></i> {{ __('Infrastructure') }}
                    </a>
                    <div class="collapse {{ (Request::is('*inventories*') || Request::is('*it-services*') || Request::is('*datacenters*') || Request::is('*networks*') || Request::is('*provision-scripts*')) ? 'show' : '' }}" id="sidebarInfrastructure">
                        <ul class="nav nav-sm flex-column">
                            @can('viewAny', \App\Models\Inventory::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('app/settings/inventories*') ? 'active' : '' }}" href="{{ action('App\InventoryController@index') }}">
                                        {{ __('Inventory')}}
                                    </a>
                                </li>
                            @endcan
                            @can('viewAny', \App\Models\ProvisionScript::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('app/settings/provision-scripts*') ? 'active' : '' }}" href="{{ action('App\ProvisionScriptController@index') }}">
                                        {{ __('Provision Scripts')}}
                                    </a>
                                </li>
                            @endcan
                            @can('viewAny', \App\Models\ItService::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('app/settings/it-services*') ? 'active' : '' }}" href="{{ action('App\ItServiceController@index') }}">
                                        {{ __('IT Services')}}
                                    </a>
                                </li>
                            @endcan
                            @can('viewAny', \App\Models\Network::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('app/settings/networks*') ? 'active' : '' }}" href="{{ action('App\NetworkController@index') }}">
                                        {{ __('Networks')}}
                                    </a>
                                </li>
                            @endcan
                            @can('viewAny', \App\Models\Datacenter::class)
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('app/settings/datacenters*') ? 'active' : '' }}" href="{{ action('App\DatacenterController@index') }}">
                                        {{ __('Datacenters')}}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @can('view-settings', Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarSettings" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSettings">
                        <i class="fe fe-settings"></i> {{ __('Settings') }}
                        </a>
                        <div class="collapse {{ Request::is('app/settings/*') && !(Request::is('*inventories*') || Request::is('*it-services*') || Request::is('*datacenters*') || Request::is('*networks*') || Request::is('*provision-scripts*')) ? 'show' : '' }}" id="sidebarSettings">
                            <ul class="nav nav-sm flex-column">
                                @can('viewAny', \App\Models\Category::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/categories*') ? 'active' : '' }}" href="{{ action('App\CategoryController@index') }}">
                                            {{ __('Categories')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Country::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/countries*') ? 'active' : '' }}" href="{{ action('App\CountryController@index') }}">
                                            {{ __('Countries')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Service::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/services*') ? 'active' : '' }}" href="{{ action('App\ServiceController@index') }}">
                                            {{ __('Services')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Report::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/reports*') ? 'active' : '' }}" href="{{ action('App\ReportController@index') }}">
                                            {{ __('Reports')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\ReportFolder::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/report-folders*') ? 'active' : '' }}" href="{{ action('App\ReportFolderController@index') }}">
                                            {{ __('Report Folders')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Role::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/roles*') ? 'active' : '' }}" href="{{ action('App\RoleController@index') }}">
                                            {{ __('Roles')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\ApiApplication::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/api-applications*') ? 'active' : '' }}" href="{{ action('App\ApiApplicationController@index') }}">
                                            {{ __('API Applications') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\TmsInstance::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/tms-instances*') ? 'active' : '' }}" href="{{ action('App\TmsInstanceController@index') }}">
                                            {{ __('TMS Instances') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Directory::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/directories*') ? 'active' : '' }}" href="{{ action('App\DirectoryController@index') }}">
                                            {{ __('Directories')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\Guide::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/guides*') ? 'active' : '' }}" href="{{ action('App\GuideController@index') }}">
                                            {{ __('Guides')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\TicketPriority::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/ticket-priorities*') ? 'active' : '' }}" href="{{ action('App\TicketPriorityController@index') }}">
                                            {{ __('Ticket Priorities')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('viewAny', \App\Models\TicketTag::class)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('app/settings/ticket-tags*') ? 'active' : '' }}" href="{{ action('App\TicketTagController@index') }}">
                                            {{ __('Ticket Tags')}}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('viewAny', \App\Models\Faq::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('app/faq*') ? 'active' : '' }}" href="{{ action('App\FaqCategoryController@index') }}">
                            <i class="fe fe-search"></i> {{ __('FAQ') }}
                        </a>
                    </li>
                @endcan

                @if(Auth::user()->hasRole(\App\Models\User::ROLE_ADMIN) || Auth::user()->hasRole(\App\Models\User::ROLE_AGENT) || Auth::user()->hasRole(\App\Models\User::ROLE_DEVELOPER) || Auth::user()->hasPermission(\App\Models\Permission::TYPE_API_DOCS))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/docs/api/Connect/overview') }}">
                            <i class="fe fe-sliders"></i> {{ __('API Documentation') }}
                        </a>
                    </li>
                @endif
            </ul>

            <hr class="my-3">

            <h6 class="navbar-heading text-muted">
                {{ __('Account') }}
            </h6>

            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('app/settings') ? 'active' : '' }}" href="{{ action('App\SettingsController@edit') }}">
                        <i class="fe fe-user"></i> {{ __('Settings') }}
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-log-out"></i> {{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
