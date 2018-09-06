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

Route::get('/', function () {
    return view('welcome');
});


Route::post('/login','backend\UserController@login');
Route::post('/register','backend\UserController@register');

Route::middleware(['authToken'])->group(function(){
  Route::resource('/roles','backend\RoleController');
  Route::get('/users','backend\UserController@index');
  Route::post('/users','backend\UserController@store');
  Route::get('/users/create/','backend\UserController@create');
  Route::get('/users/{id}','backend\UserController@show');
  Route::put('/users/{id}','backend\UserController@update');

  Route::resource('/menurol','backend\MenuRolController');
  Route::resource('/permissions','backend\PermissionController');
  Route::resource('/menus','backend\MenuController');
});
