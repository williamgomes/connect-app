<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Applications
Route::get('/application', 'ApiApplicationController@identify');

// Users
Route::get('/users', 'UserController@index');
Route::post('/users', 'UserController@store');
Route::get('/users/{user}', 'UserController@show');
Route::patch('/users/{user}', 'UserController@update');

// Tickets
Route::get('/tickets', 'TicketController@index');
Route::post('/tickets', 'TicketController@store');
Route::get('/tickets/{ticket}', 'TicketController@show');
Route::patch('/tickets/{ticket}', 'TicketController@update');
Route::post('/tickets/{ticket}/reply', 'TicketController@reply');
Route::post('/tickets/{ticket}/mark-as-solved', 'TicketController@markAsSolved');
