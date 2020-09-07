<?php

use App\Http\Controllers\HomeController;
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


Route::get('/signin', 'UserController@showsignin')->name('show.signin');
Route::post('/user/signin', 'UserController@signin')->name('user.signin');

Route::get('/user/logout', 'UserController@logout')->name('user.logout');

Route::get('/register','UserController@showregister')->name('show.register');
Route::post('/user/register','UserController@register')->name('user.register');




Route::get('/reset-password/send','PasswordController@showsendemail')->name('reset.password.email');
Route::post('/reset-password/send','PasswordController@sendemail')->name('reset.password.send');
Route::get('/reset-password/{user}/{code}','PasswordController@resetPasswordForm')->name('reset.password');
Route::post('/reset-password/{user}/{code}','PasswordController@resetPassword')->name('reset.password.update');


Route::get('/verificate/{user}/{kod}', 'UserController@verificateForm')->name('user.verificate.form');

Route::middleware(['sentinelauth' ])->group(function(){

Route::get('/user/{user}/profile','UserController@userprofile')->name('user.profile');
Route::get('/user/{user}/orders','UserController@orders')->name('user.orders');
Route::get('/products','UserController@products')->name('products');


Route::put('/user/{user}/edit','UserController@edit')->name('user.edit');

Route::get('/','HomeController@show')->name('home');


});





