<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Services\Twitter\TwitterService;

Route::get('/', function (TwitterService $twitter) {
    $mentions = $twitter->getMentions('123');
    dd($mentions);
    return view('welcome');
});
