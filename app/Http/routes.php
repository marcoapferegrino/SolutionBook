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

Route::group(['middleware' => 'auth'],function(){


   Route::group(['middleware' => 'role:super'],function() {
        //susped account
        Route::post('/activeAccount', [
           'as' => 'users.activeAccount',
           'uses' => 'UsersController@activeAccount'
        ]);

        Route::post('/addNotice', [
            'as' => 'notices.addNotice',
            'uses' => 'NoticesController@addNotice'
        ]);

        Route::delete('/deleteNotice', [
            'as' => 'notices.deleteNotice',
            'uses' => 'NoticesController@deleteNotice'
        ]);

        Route::post('/updateNotice', [
            'as' => 'notices.updateNotice',
            'uses' => 'NoticesController@updateNotice'
        ]);

        Route::post('/addProblemSetter', [
            'as' => 'users.addProblemSetter',
            'uses' => 'UsersController@addProblemSetter'
        ]);

        Route::get('/showJudges', [
            'as' => 'judges.showJudges',
            'uses' => 'JudgesController@showJudges'
        ]);

        Route::post('/addJudge', [
            'as' => 'judges.addJudge',
            'uses' => 'JudgesController@addJudge'
        ]);

        Route::delete('/deleteJudge/{$id}', [
            'as' => 'judges.deleteJudge',
            'uses' => 'JudgesController@deleteJudge'
        ]);
        Route::post('/updateJudge', [
            'as' => 'judges.updateJudge',
            'uses' => 'JudgesController@updateJudge'
        ]);




        });
    Route::group(['middleware' => 'role:problem'],function() {

        Route::post('/addProblem', [
            'as' => 'problem.addProblem',
            'uses' => 'ProblemsController@addProblem'
        ]);

        Route::delete('/deleteProblem/{$id}', [
            'as' => 'problem.deleteProblem',
            'uses' => 'ProblemsController@deleteProblem'
        ]);
        Route::post('/updateProblem/{$id}', [
            'as' => 'problem.updateProblem',
            'uses' => 'ProblemsController@updateProblem'
        ]);

        Route::get('/myProblems', [
            'as' => 'problem.myProblems',
            'uses' => 'ProblemsController@myProblems'
        ]);
        Route::get('/showProblem', [ //para guest
            'as' => 'problem.showProblem',
            'uses' => 'ProblemsController@showProblem'
        ]);
        Route::post('/promotion', [ //+ y -
            'as' => 'users.promotion',
            'uses' => 'UsersController@promotion'
        ]);

        Route::get('/showWarning', [
            'as' => 'warning.showWarning',
            'uses' => 'WarningsController@showWarning'
        ]);

        Route::post('/ignoreWarning', [
            'as' => 'warning.ignoreWarning',
            'uses' => 'WarningsController@ignoreWarning'
        ]);

        Route::get('/showResolution', [
            'as' => 'warning.showResolution',
            'uses' => 'WarningsController@showResolution'
        ]);

        Route::post('/resolution', [
            'as' => 'warning.resolution',
            'uses' => 'WarningsController@resolution'
        ]);

        });


    Route::group(['middleware' => 'role:solver'],function() {



        Route::post('/addSolution', [ //peticion para agregar solucion
            'as' => 'solution.addSolution',
            'uses' => 'SolutionsController@addSolution'
        ]);

        Route::get('/addFormSolution', [ //muestra formulario para agregar solucion
            'as' => 'solution.getFormSolution',
            'uses' => 'SolutionsController@getFormSolution'
        ]);

        Route::delete('/deleteSolution/{$id}', [
            'as' => 'solution.deleteSolution',
            'uses' => 'SolutionsController@deleteSolution'
        ]);
        Route::post('/updateSolution/{$id}', [
            'as' => 'solution.updateSolution',
            'uses' => 'SolutionsController@updateSolution'
        ]);

        Route::get('/mySolutions', [
            'as' => 'solution.mySolutions',
            'uses' => 'SolutionsController@mySolutions'
        ]);
        Route::get('/showSolution', [ //para guest
            'as' => 'solution.showSolution',
            'uses' => 'SolutionsController@showSolution'
        ]);
        Route::post('/addlike', [
            'as' => 'likes.addLike',
            'uses' => 'LikesController@addLike'
        ]);

        Route::post('/dislike', [
            'as' => 'likes.disLike',
            'uses' => 'LikesController@disLike'
        ]);

        Route::post('/suspendAccount', [
            'as' => 'users.suspendAccount',
            'uses' => 'UsersController@suspendAccount'
        ]);

        Route::post('/addWarning/{$type}', [ //si es 1 es problema si es 0 es solución
            'as' => 'warning.addWarning',
            'uses' => 'WarningsController@addWarning'
        ]);

        Route::get('/myWarnings', [
            'as' => 'warning.myWarnings',
            'uses' => 'WarningsController@myWarnings'
        ]);


        });


    });



