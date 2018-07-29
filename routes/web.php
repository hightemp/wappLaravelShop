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

$sAdminDir = config('app.sAdminDir');

/*
Route::group([
  'prefix' => "{language}/$sAdminPath",
  'middleware' => ['web', 'auth']
], function()
{
  Route::get("/", [
      'as' => 'admin.dashboard',
      'uses' => 'Admin\IndexController@index'
  ]);
});

Route::group([
  'prefix' => "{language}",
], function()
{
  Route::get("logout", [
      'as' => 'logout',
      'uses' => 'LoginController@index'
  ])->where('language', '\w+');

  Route::post("login", [
      'as' => 'login',
      'uses' => 'LoginController@index'
  ])->where('language', '\w+');

  Route::get("register", [
      'uses' => 'RegisterController@index'
  ])->where('language', '\w+');

  Route::get('/{id}', 'AnyRequestController@show')->where('language', '\w+')->where('id', '.*');
  Route::get('/', [
      'as' => 'home',
      'uses' => 'AnyRequestController@index'
  ]);
});

Route::get('/', [
    'as' => 'home',
    'uses' => 'AnyRequestController@index'
]);

Auth::routes();

*/

Route::group(
  [
    'prefix' => $sAdminDir,
    'middleware' => [/*'web', 'auth'*/]
  ], 
  function()
  {
    Route::get("/", 'Backend\DashboardController@fnShow');
  }
);

Route::get('/', 'Frontend\HomeController@fnShow');

Route::any(
  '{all}', 
  function()
  {
    return fnThemeView('error');
  }
)->where('all', '.*');