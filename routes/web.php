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
    return view('welcome');
});

Auth::routes();

Route::get('install', 'InstallerController@index')->name('install');
Route::post('install', 'InstallerController@process_install')->name('process_install');
Route::get('install-success','InstallerController@install_success')->name('install_success');
Route::get('install-fail','InstallerController@install_fail')->name('install_fail');

Route::group(['middleware' => ['install','auth']], function () {
    //Route::resource('admin/posts', 'Admin\\PostsController');
    Route::resource('admin/comments', 'Admin\\CommentsController');
    Route::resource('admin/terms', 'Admin\\TermsController');
    Route::resource('admin/post_-term', 'Admin\\Post_TermController');
    //Route::resource('admin/posts', 'Admin\\PostsController');
    Route::get('/home', 'HomeController@index')->name('home');
    do_action( 'admin_web_routes-web.php' );
});

do_action( 'public_web_routes-web.php' );