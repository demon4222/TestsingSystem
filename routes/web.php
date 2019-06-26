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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'],function (){

    Route::group(['middleware' => 'isAdmin'], function (){
        Route::get('/test/create', 'TestController@createIndex')->name('create_test');

        Route::post('/test/create/add_question_ajax', 'QuestionController@addNewQuestionToSession');

        Route::get('/test/create/newQuestionView', 'QuestionController@newQuestionView');

        Route::get('/test/addTestName', 'TestController@addTestName');

        Route::get('/test/endCreation', 'TestController@endTestCreation');

        Route::get('/rating', 'ResultController@indexRating');

        Route::get('/testList', 'TestController@getAdminTestList');

        Route::delete('/test/delete/{id}', 'TestController@delete');
    });

    Route::get('/test/{test_id}', 'TestController@startTest');

    Route::get('/tests', 'TestController@getTestsList');

    Route::get('/get_question', 'TestController@getNewQuestion');

    Route::post('/test/saveAnswerToSession', 'TestController@saveAnswerToSession');

    Route::get('/result', 'TestController@showCurrentTestResult');

    Route::get('/myresults','ResultController@indexUser');
});

