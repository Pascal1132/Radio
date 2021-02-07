<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('front-end.home');
})->name ('home');




Route::middleware([\App\Http\Middleware\NotAuthenticate::class])->group(function () {
Route::get('/cms/home', function () {
    return view('cms.home');
})->name ('cms.home');
    Route::get('/cms/command', 'CMSController@command')->name ('cms.command');
    Route::get('/cms/channels', 'CMSController@channels')->name ('cms.channels');
    Route::get('/cms/range', 'CMSController@range')->name ('cms.range');
    Route::post('/cms/range', 'CMSController@rangePost')->name ('cms.range');
    Route::post('/cms/command', 'CMSController@commandPost')->name ('cms.command');
    Route::post('/cms/mount_point_icecast', 'CMSController@mountPointIcecast')->name ('cms.mount_point_icecast');
    Route::get('/cms/channels/table', 'CMSController@returnViewTableChannels')->name ('cms.channels.table');
    Route::post('/cms/channel', 'CMSController@addChannel')->name ('cms.channel.add');
    Route::delete('/cms/channel', 'CMSController@removeChannel')->name ('cms.channel.remove');
});
Route::middleware([\App\Http\Middleware\RedirectIfAuthenticated::class])->group(function () {
    Route::get('/cms', function () {
        return view('cms.login');
    })->name ('cms.login');
});
Route::post('/cms/login', 'CMSController@login')->name ('cms.login');
Route::get('/cms/logout', 'CMSController@logout')->name ('cms.logout');

Route::post('/execute/command', 'DefaultController@executeCommand');
Route::post('/execute/command-kill', 'DefaultController@executeCommandKill');
Route::get('/options', 'DefaultController@getOptions');
Route::get('/frequency', 'DefaultController@getFrequency');
Route::post('/save/command-options', 'DefaultController@saveCommandOptions')->name ('command_options');
