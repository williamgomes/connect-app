<?php

// Categories
Route::get('/categories/{category}/subcategories', 'CategoryController@subcategories');
Route::get('/categories/{category}/fields', 'CategoryController@fields');

// Issue Attachments
Route::delete('issue-attachments/{issueAttachment}', 'IssueAttachmentController@destroy');

// Directories
Route::get('/directories/{directory}', 'DirectoryController@show');
Route::get('/directories/{directory}/companies', 'DirectoryController@companies');

// Editor
Route::post('files/{path}', 'EditorController@store');

Route::get('/report-budgets', 'ReportBudgetController@show');

// FAQ
Route::post('/faq/sort', 'FaqController@sort');
Route::post('/faq-categories/sort', 'FaqCategoryController@sort');
