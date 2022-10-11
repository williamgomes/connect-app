<?php

namespace Database\Seeders;

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
use App\Models\Document;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Guide;
use App\Models\Inventory;
use App\Models\IpAddress;
use App\Models\Issue;
use App\Models\IssueAttachment;
use App\Models\ItService;
use App\Models\Network;
use App\Models\ProvisionScript;
use App\Models\Report;
use App\Models\ReportFolder;
use App\Models\Role;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketCommentAttachment;
use App\Models\TicketPriority;
use App\Models\TicketTag;
use App\Models\TmsInstance;
use App\Models\UserEmail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * It's currently used for testing only.
     *
     * @return void
     */
    public function run()
    {
        Country::factory(3)->create();
        Service::factory(3)->create();
        TmsInstance::factory(3)->create();
        Directory::factory(3)->create();
        Company::factory(3)->create();
        Role::factory(3)->create();
        Application::factory(3)->create();
        Datacenter::factory(3)->create();
        ItService::factory(3)->create();
        Network::factory(3)->create();

        $this->call([
            UserSeeder::class,
        ]);

        ProvisionScript::factory(3)->create();
        Guide::factory(3)->create();
        Inventory::factory(3)->create();
        Category::factory(3)->create();
        CategoryField::factory(3)->create();
        TicketPriority::factory(3)->create();
        TicketTag::factory(3)->create();
        Ticket::factory(3)->create()
            ->each(function ($ticket) {
                $ticket->ticketTags()->attach(TicketTag::inRandomOrder()->first());
            });
        TicketCommentAttachment::factory(3)->create();
        ReportFolder::factory(3)->create();
        Report::factory(3)->create();
        BlogPost::factory(3)->create();
        IpAddress::factory(3)->create();
        ApiApplication::factory(3)->create();
        ApiApplicationToken::factory(3)->create();
        FaqCategory::factory(3)->create();
        Faq::factory(3)->create();
        Document::factory(3)->create();
        Issue::factory(3)->create();
        IssueAttachment::factory(3)->create();
        ApplicationUser::factory(3)->create();
        UserEmail::factory(3)->create();
    }
}
