<?php

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', 'HomeController@index');

// User Verification
Route::get('/verify', 'UserVerificationController@create');
Route::post('/verify', 'UserVerificationController@store');
Route::get('/verify/{token}', 'UserVerificationController@complete');
Route::post('/verify/{token}', 'UserVerificationController@update');

// Unsubscribe link
Route::get('/blog/{hash}/unsubscribe', 'UserController@unsubscribeBlogFromHash');

// User Emails
Route::post('/emails/process', 'UserEmailController@processIncomingEmail')->middleware('guest');

Auth::routes();
