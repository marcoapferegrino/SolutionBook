<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('likes',function(){

     $solutionsUsers = DB::table('users')
        ->join('solution_user', 'solution_user.user_id', '=', 'users.id')
         ->join('solutions', 'solutions.id', '=', 'solution_user.solution_id')
        ->select('users.id','users.username', 'solution_user.user_id', 'solution_user.solution_id', 'solutions.id', 'solutions.explanation')
        ->get();

    dd($solutionsUsers);
});

