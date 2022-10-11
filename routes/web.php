<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware group. Now create something great!
|
*/

// Help Center
Route::get('/help-center', 'HelpCenterController@index');

// Blog
Route::get('/blog', 'BlogController@index');
Route::get('/blog/{blogPost}', 'BlogController@show');

// Self Service
Route::get('/self-service/password', 'SelfServiceController@createPassword');
Route::post('/self-service/password', 'SelfServiceController@storePassword');
Route::get('/self-service/passcode', 'SelfServiceController@createPasscode');
Route::post('/self-service/passcode', 'SelfServiceController@storePasscode');
Route::get('/self-service/phone', 'SelfServiceController@createPhone');
Route::post('/self-service/phone', 'SelfServiceController@storePhone');

// Tickets
Route::get('/tickets/{status?}', 'TicketController@index')->where('status', 'open|solved|closed');
Route::get('/tickets/create', 'TicketController@create');
Route::get('/tickets/attachments/{ticketCommentAttachment}/download', 'TicketController@downloadAttachment');
Route::post('/tickets/create', 'TicketController@store');
Route::get('/tickets/{ticket}', 'TicketController@show');
Route::post('/tickets/{ticket}/reply', 'TicketController@reply');
Route::post('/tickets/{ticket}/solve', 'TicketController@markAsSolved');

// Issues
Route::get('/issues/{status?}', 'IssueController@index')->where('status', 'awaiting_specification|backlog|in_progress|quality_assurance|done|declined');
Route::get('/issues/{issue}', 'IssueController@show');

// Issues
Route::get('issues/{issue}', 'IssueController@show');

// Reports
Route::get('reports/{report}', 'ReportController@show');

// Report Folders
Route::get('report-folders', 'ReportFolderController@index');
Route::get('report-folders/{reportFolder}', 'ReportFolderController@show');

// FAQ Category
Route::get('faq-categories', 'FaqCategoryController@index');
Route::get('faq-categories/{faqCategory}', 'FaqCategoryController@show');

// FAQ
Route::get('faqs/{faq}', 'FaqController@show');

// Categories
Route::get('/categories/{category}/subcategories', 'CategoryController@subcategories');
Route::get('/categories/{category}/fields', 'CategoryController@fields');

// Editor
Route::get('files/{path?}/{fileName}', 'EditorController@show')->where('path', '(.*)');

// Provision Scripts
Route::get('inventories/{uuid}/{provisionScript}', 'ProvisionScriptController@show');

// User Emails
Route::get('/emails', 'UserEmailController@index');
Route::get('/emails/{userEmail}', 'UserEmailController@show');
Route::post('/emails/mark-as-read', 'UserEmailController@markAsRead');
Route::post('/emails/mark-as-unread', 'UserEmailController@markAsUnread');
