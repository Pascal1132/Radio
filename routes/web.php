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
    Route::post('/cms/command', 'CMSController@commandPost')->name ('cms.command');
    Route::post('/cms/mount_point_icecast', 'CMSController@mountPointIcecast')->name ('cms.mount_point_icecast');
});
Route::middleware([\App\Http\Middleware\RedirectIfAuthenticated::class])->group(function () {
    Route::get('/cms', function () {
        return view('cms.login');
    })->name ('cms.login');
});
Route::post('/cms/login', 'CMSController@login')->name ('cms.login');

Route::post('/execute/command', 'DefaultController@executeCommand');
