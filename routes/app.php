<?php
/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
| Here is where you can register app routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware group. Now create something great!
|
*/

// Dashboard
Route::get('/dashboard', 'DashboardController@show');

// Users
Route::get('users', 'UserController@index');
Route::get('users/create', 'UserController@create');
Route::post('users', 'UserController@store');
Route::get('users/{user}', 'UserController@show');
Route::get('users/{user}/edit', 'UserController@edit');
Route::post('users/{user}', 'UserController@update');
Route::post('users/{user}/activate', 'UserController@activate');
Route::post('users/{user}/deactivate', 'UserController@deactivate');
Route::post('users/{user}/profile-picture', 'UserController@updateProfilePicture');
Route::post('users/{user}/documents', 'DocumentController@store');
Route::get('users/{user}/tickets', 'UserController@tickets');

// Role Users
Route::get('/users/{user}/roles/create', 'RoleUserController@create');
Route::post('/users/{user}/roles', 'RoleUserController@store');
Route::delete('/role-users/{roleUser}', 'RoleUserController@destroy');

// Applications
Route::get('applications', 'ApplicationController@index');
Route::get('applications/create', 'ApplicationController@create');
Route::post('applications', 'ApplicationController@store');
Route::get('applications/{application}/edit', 'ApplicationController@edit');
Route::post('applications/{application}', 'ApplicationController@update');
Route::delete('applications/{application}', 'ApplicationController@destroy');

// Application Users
Route::get('/users/{user}/applications/{application}/regenerate-password', 'ApplicationUserController@regeneratePasswordForm');
Route::post('/users/{user}/applications/{application}/regenerate-password', 'ApplicationUserController@regeneratePassword');
Route::get('/users/{user}/applications/create', 'ApplicationUserController@create');
Route::post('/users/{user}/applications/store', 'ApplicationUserController@store');
Route::delete('/application-users/{applicationUser}', 'ApplicationUserController@destroy');

// Tickets
Route::get('/tickets/{status?}', 'TicketController@index')->where('status', 'open|solved|closed');
Route::get('/tickets/create', 'TicketController@create');
Route::get('/tickets/attachments/{ticketCommentAttachment}/download', 'TicketController@downloadAttachment');
Route::post('/tickets', 'TicketController@store');
Route::get('/tickets/{ticket}', 'TicketController@show');
Route::get('/tickets/{ticket}/edit', 'TicketController@edit');
Route::post('/tickets/{ticket}', 'TicketController@update');
Route::post('/tickets/{ticket}/reply', 'TicketController@reply');
Route::post('/tickets/{ticket}/solve', 'TicketController@markAsSolved');
Route::post('/tickets/{ticket}/remind', 'TicketController@remindRequester');
Route::post('/tickets/{ticket}/watchers', 'TicketController@createWatcher');
Route::delete('/tickets/{ticket}/watchers/{user}', 'TicketController@destroyWatcher');
Route::post('/tickets/{ticket}/tags', 'TicketController@createTicketTag');
Route::delete('/tickets/{ticket}/tags/{ticketTag}', 'TicketController@destroyTicketTag');

// User Emails
Route::get('/users/{user}/emails', 'UserEmailController@index');
Route::get('/users/{user}/emails/{userEmail}', 'UserEmailController@show');

// Companies
Route::get('companies', 'CompanyController@index');
Route::get('companies/create', 'CompanyController@create');
Route::post('companies', 'CompanyController@store');
Route::get('companies/{company}', 'CompanyController@show');
Route::get('companies/{company}/edit', 'CompanyController@edit');
Route::post('companies/{company}', 'CompanyController@update');
Route::delete('companies/{company}', 'CompanyController@destroy');
Route::get('companies/{company}/roles/{role}', 'CompanyController@editRole');
Route::post('companies/{company}/roles/{role}', 'CompanyController@updateRole');

// Issues
Route::get('issues', 'IssueController@index');
Route::get('issues/create', 'IssueController@create');
Route::post('issues', 'IssueController@store');
Route::get('issues/{issue}', 'IssueController@show');
Route::get('issues/{issue}/edit', 'IssueController@edit');
Route::post('issues/{issue}', 'IssueController@update');
Route::post('issues/{issue}/comments/create', 'IssueController@addComment');

// Issue Attachments
Route::get('issue-attachments/{issueAttachment}', 'IssueController@showAttachment');

// Documents
Route::get('/documents/{document}/download', 'DocumentController@download');
Route::get('/documents/{document}', 'DocumentController@view');

// Settings
Route::get('/settings', 'SettingsController@edit');
Route::post('/settings', 'SettingsController@update');

// TMS Instances
Route::get('/reports/tms-instances', 'ReportController@tmsInstances');
Route::get('/reports/tms-instances/{tmsInstance}', 'ReportController@showTmsInstance');
Route::get('/reports/tms-instances/{tmsInstance}/type/{type}/period/{period}', 'ReportController@editBudget');
Route::post('/reports/tms-instances/{tmsInstance}/type/{type}/period/{period}', 'ReportController@updateBudget');

// Reports
Route::get('reports/{report}', 'ReportController@show');

// FAQ
Route::get('faq-categories/{faqCategory}/faq/create', 'FaqController@create');
Route::post('faq-categories/{faqCategory}/faq', 'FaqController@store');
Route::get('faq-categories/{faqCategory}/faq/{faq}/edit', 'FaqController@edit');
Route::post('faq-categories/{faqCategory}/faq/{faq}', 'FaqController@update');

// FAQ Category
Route::get('faq-categories', 'FaqCategoryController@index');
Route::get('faq-categories/create', 'FaqCategoryController@create');
Route::post('faq-categories', 'FaqCategoryController@store');
Route::get('faq-categories/{faqCategory}/edit', 'FaqCategoryController@edit');
Route::get('faq-categories/{faqCategory}', 'FaqCategoryController@show');
Route::post('faq-categories/{faqCategory}', 'FaqCategoryController@update');
Route::delete('faq-categories/{faqCategory}', 'FaqCategoryController@destroy');

// Settings
Route::group(['prefix' => '/settings'], function () {
    // Api Applications
    Route::get('api-applications', 'ApiApplicationController@index');
    Route::get('api-applications/create', 'ApiApplicationController@create');
    Route::post('api-applications', 'ApiApplicationController@store');
    Route::get('api-applications/{apiApplication}', 'ApiApplicationController@show');
    Route::get('api-applications/{apiApplication}/edit', 'ApiApplicationController@edit');
    Route::post('api-applications/{apiApplication}', 'ApiApplicationController@update');

    // Api Application Tokens
    Route::get('api-applications/{apiApplication}/tokens/create', 'ApiApplicationTokenController@create');
    Route::post('api-applications/{apiApplication}/tokens', 'ApiApplicationTokenController@store');
    Route::post('api-applications/{apiApplication}/tokens/{apiApplicationToken}', 'ApiApplicationTokenController@revoke');

    // Services
    Route::get('services', 'ServiceController@index');
    Route::get('services/create', 'ServiceController@create');
    Route::post('services', 'ServiceController@store');
    Route::get('services/{service}/edit', 'ServiceController@edit');
    Route::post('services/{service}', 'ServiceController@update');
    Route::delete('services/{service}', 'ServiceController@destroy');

    // Reports
    Route::get('reports', 'ReportController@index');
    Route::get('reports/create', 'ReportController@create');
    Route::post('reports', 'ReportController@store');
    Route::get('reports/{report}/edit', 'ReportController@edit');
    Route::post('reports/{report}', 'ReportController@update');
    Route::delete('reports/{report}', 'ReportController@destroy');

    // Report Folders
    Route::get('report-folders', 'ReportFolderController@index');
    Route::get('report-folders/create', 'ReportFolderController@create');
    Route::post('report-folders', 'ReportFolderController@store');
    Route::get('report-folders/{reportFolder}', 'ReportFolderController@show');
    Route::get('report-folders/{reportFolder}/edit', 'ReportFolderController@edit');
    Route::post('report-folders/{reportFolder}', 'ReportFolderController@update');
    Route::delete('report-folders/{reportFolder}', 'ReportFolderController@destroy');

    // Guides
    Route::get('guides', 'GuideController@index');
    Route::get('guides/create', 'GuideController@create');
    Route::post('guides', 'GuideController@store');
    Route::get('guides/{guide}/{inventoryId?}', 'GuideController@show');
    Route::get('guides/{guide}/edit', 'GuideController@edit');
    Route::post('guides/{guide}', 'GuideController@update');
    Route::delete('guides/{guide}', 'GuideController@destroy');

    // IT Services
    Route::get('it-services', 'ItServiceController@index');
    Route::get('it-services/create', 'ItServiceController@create');
    Route::post('it-services', 'ItServiceController@store');
    Route::get('it-services/{itService}/edit', 'ItServiceController@edit');
    Route::post('it-services/{itService}', 'ItServiceController@update');
    Route::delete('it-services/{itService}', 'ItServiceController@destroy');

    // Datacenters
    Route::get('datacenters', 'DatacenterController@index');
    Route::get('datacenters/create', 'DatacenterController@create');
    Route::post('datacenters', 'DatacenterController@store');
    Route::get('datacenters/{datacenter}/edit', 'DatacenterController@edit');
    Route::post('datacenters/{datacenter}', 'DatacenterController@update');
    Route::delete('datacenters/{datacenter}', 'DatacenterController@destroy');

    // IP Addresses
    Route::post('ip-addresses', 'IpAddressController@store');
    Route::get('ip-addresses/{ipAddress}/edit', 'IpAddressController@edit');
    Route::post('ip-addresses/{ipAddress}', 'IpAddressController@update');
    Route::delete('ip-addresses/{ipAddress}', 'IpAddressController@destroy');

    // Inventories
    Route::get('inventories', 'InventoryController@index');
    Route::get('inventories/create', 'InventoryController@create');
    Route::post('inventories', 'InventoryController@store');
    Route::get('inventories/{inventory}', 'InventoryController@show');
    Route::get('inventories/{inventory}/edit', 'InventoryController@edit');
    Route::post('inventories/{inventory}', 'InventoryController@update');
    Route::delete('inventories/{inventory}', 'InventoryController@destroy');
    Route::get('inventories/{inventory}/ip-addresses/create', 'InventoryController@createIpAddress');

    Route::get('inventories/{inventory}/provision-scripts/create', 'InventoryController@createProvisionScript');
    Route::post('inventories/{inventory}/provision-scripts', 'InventoryController@storeProvisionScript');
    Route::get('inventories/{inventory}/provision-scripts/{provisionScript}/edit', 'InventoryController@editProvisionScript');
    Route::post('inventories/{inventory}/provision-scripts/{provisionScript}', 'InventoryController@updateProvisionScript');
    Route::delete('inventories/{inventory}/provision-scripts/{provisionScript}', 'InventoryController@destroyProvisionScript');

    Route::get('inventories/{inventory}/guides/create', 'InventoryController@addGuide');
    Route::post('inventories/{inventory}/guides', 'InventoryController@storeGuide');
    Route::delete('inventories/{inventory}/guides/{guide}', 'InventoryController@destroyGuide');

    // Networks
    Route::get('networks', 'NetworkController@index');
    Route::get('networks/create', 'NetworkController@create');
    Route::post('networks', 'NetworkController@store');
    Route::get('networks/{network}', 'NetworkController@show');
    Route::get('networks/{network}/edit', 'NetworkController@edit');
    Route::post('networks/{network}', 'NetworkController@update');
    Route::delete('networks/{network}', 'NetworkController@destroy');
    Route::get('networks/{network}/ip-addresses/create', 'NetworkController@createIpAddress');

    // Provision Scripts
    Route::get('provision-scripts', 'ProvisionScriptController@index');
    Route::get('provision-scripts/create', 'ProvisionScriptController@create');
    Route::post('provision-scripts', 'ProvisionScriptController@store');
    Route::get('provision-scripts/{provisionScript}/edit', 'ProvisionScriptController@edit');
    Route::post('provision-scripts/{provisionScript}', 'ProvisionScriptController@update');
    Route::delete('provision-scripts/{provisionScript}', 'ProvisionScriptController@destroy');

    // Roles
    Route::get('roles', 'RoleController@index');
    Route::get('roles/create', 'RoleController@create');
    Route::post('roles', 'RoleController@store');
    Route::get('roles/{role}/edit', 'RoleController@edit');
    Route::post('roles/{role}', 'RoleController@update');
    Route::delete('roles/{role}', 'RoleController@destroy');

    // Categories
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/create', 'CategoryController@create');
    Route::post('categories', 'CategoryController@store');
    Route::get('categories/{category}/edit', 'CategoryController@edit');
    Route::post('categories/{category}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@destroy');

    // Category Fields
    Route::get('categories/{category}/fields/create', 'CategoryFieldController@create');
    Route::post('categories/{category}/fields', 'CategoryFieldController@store');
    Route::get('categories/{category}/fields/{categoryField}/edit', 'CategoryFieldController@edit');
    Route::post('categories/{category}/fields/{categoryField}', 'CategoryFieldController@update');
    Route::delete('categories/{category}/fields/{categoryField}', 'CategoryFieldController@destroy');

    // Directories
    Route::get('directories', 'DirectoryController@index');
    Route::get('directories/create', 'DirectoryController@create');
    Route::post('directories', 'DirectoryController@store');
    Route::get('directories/{directory}/edit', 'DirectoryController@edit');
    Route::post('directories/{directory}', 'DirectoryController@update');
    Route::delete('directories/{directory}', 'DirectoryController@destroy');

    // Directory User
    Route::get('directory-users/{directoryUser}/edit', 'DirectoryUserController@edit');
    Route::post('directory-users/{directoryUser}', 'DirectoryUserController@update');

    // Countries
    Route::get('countries', 'CountryController@index');
    Route::get('countries/create', 'CountryController@create');
    Route::post('countries', 'CountryController@store');
    Route::get('countries/{country}/edit', 'CountryController@edit');
    Route::post('countries/{country}', 'CountryController@update');
    Route::delete('countries/{country}', 'CountryController@destroy');

    // Blog Posts
    Route::get('blog-posts', 'BlogPostController@index');
    Route::get('blog-posts/create', 'BlogPostController@create');
    Route::post('blog-posts', 'BlogPostController@store');
    Route::get('blog-posts/{blogPost}/edit', 'BlogPostController@edit');
    Route::post('blog-posts/{blogPost}', 'BlogPostController@update');
    Route::delete('blog-posts/{blogPost}', 'BlogPostController@destroy');

    // TMS Instances
    Route::get('tms-instances', 'TmsInstanceController@index');
    Route::get('tms-instances/create', 'TmsInstanceController@create');
    Route::post('tms-instances', 'TmsInstanceController@store');
    Route::get('tms-instances/{tmsInstance}/edit', 'TmsInstanceController@edit');
    Route::post('tms-instances/{tmsInstance}', 'TmsInstanceController@update');
    Route::delete('tms-instances/{tmsInstance}', 'TmsInstanceController@destroy');

    // Ticket Priorities
    Route::get('ticket-priorities', 'TicketPriorityController@index');
    Route::get('ticket-priorities/create', 'TicketPriorityController@create');
    Route::post('ticket-priorities', 'TicketPriorityController@store');
    Route::get('ticket-priorities/{ticketPriority}/edit', 'TicketPriorityController@edit');
    Route::post('ticket-priorities/{ticketPriority}', 'TicketPriorityController@update');
    Route::delete('ticket-priorities/{ticketPriority}', 'TicketPriorityController@destroy');

    // Ticket Tag
    Route::get('ticket-tags', 'TicketTagController@index');
    Route::get('ticket-tags/create', 'TicketTagController@create');
    Route::post('ticket-tags', 'TicketTagController@store');
    Route::get('ticket-tags/{ticketTag}/edit', 'TicketTagController@edit');
    Route::post('ticket-tags/{ticketTag}', 'TicketTagController@update');
    Route::delete('ticket-tags/{ticketTag}', 'TicketTagController@destroy');
});
