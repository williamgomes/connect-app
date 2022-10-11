<?php

namespace App\Providers;

use App\Models\ApiApplication;
use App\Models\ApiApplicationToken;
use App\Models\Application;
use App\Models\ApplicationUser;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Company;
use App\Models\Country;
use App\Models\Datacenter;
use App\Models\Directory;
use App\Models\DirectoryUser;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Guide;
use App\Models\Inventory;
use App\Models\Issue;
use App\Models\ItService;
use App\Models\Network;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TmsInstance;
use App\Models\User;
use App\Policies\ApiApplicationPolicy;
use App\Policies\ApiApplicationTokenPolicy;
use App\Policies\ApplicationPolicy;
use App\Policies\ApplicationUserPolicy;
use App\Policies\BlogPostPolicy;
use App\Policies\CategoryFieldPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\CountryPolicy;
use App\Policies\DatacenterPolicy;
use App\Policies\DirectoryPolicy;
use App\Policies\DirectoryUserPolicy;
use App\Policies\FaqCategoryPolicy;
use App\Policies\FaqPolicy;
use App\Policies\GuidePolicy;
use App\Policies\InventoryPolicy;
use App\Policies\IssuePolicy;
use App\Policies\ItServicePolicy;
use App\Policies\RolePolicy;
use App\Policies\RoleUserPolicy;
use App\Policies\ServicePolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Application::class         => ApplicationPolicy::class,
        ApplicationUser::class     => ApplicationUserPolicy::class,
        ApiApplication::class      => ApiApplicationPolicy::class,
        ApiApplicationToken::class => ApiApplicationTokenPolicy::class,
        Datacenter::class          => DatacenterPolicy::class,
        DirectoryUser::class       => DirectoryUserPolicy::class,
        BlogPost::class            => BlogPostPolicy::class,
        Category::class            => CategoryPolicy::class,
        CategoryField::class       => CategoryFieldPolicy::class,
        Company::class             => CompanyPolicy::class,
        Country::class             => CountryPolicy::class,
        Directory::class           => DirectoryPolicy::class,
        Faq::class                 => FaqPolicy::class,
        FaqCategory::class         => FaqCategoryPolicy::class,
        Guide::class               => GuidePolicy::class,
        Inventory::class           => InventoryPolicy::class,
        Issue::class               => IssuePolicy::class,
        ItService::class           => ItServicePolicy::class,
        Role::class                => RolePolicy::class,
        RoleUser::class            => RoleUserPolicy::class,
        Service::class             => ServicePolicy::class,
        Ticket::class              => TicketPolicy::class,
        User::class                => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-settings', function ($user) {
            if ($user->can('viewAny', ApiApplication::class)) {
                return true;
            }

            if ($user->can('viewAny', CategoryPolicy::class)) {
                return true;
            }

            if ($user->can('viewAny', CountryPolicy::class)) {
                return true;
            }

            if ($user->can('viewAny', Role::class)) {
                return true;
            }

            if ($user->can('viewAny', ServicePolicy::class)) {
                return true;
            }

            if ($user->can('viewAny', TmsInstance::class)) {
                return true;
            }

            if ($user->can('viewAny', Directory::class)) {
                return true;
            }

            if ($user->can('viewAny', ItService::class)) {
                return true;
            }

            if ($user->can('viewAny', Datacenter::class)) {
                return true;
            }

            if ($user->can('viewAny', Inventory::class)) {
                return true;
            }

            if ($user->can('viewAny', Network::class)) {
                return true;
            }

            return false;
        });

        Gate::define('view-reports', function ($user) {
            if ($user->can('viewAnyReport', TmsInstance::class)) {
                return true;
            }

            return false;
        });
    }
}
