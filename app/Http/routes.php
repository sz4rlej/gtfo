<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/',[
    'as' => 'home', 'uses' => 'HomeController@home'
]);

$app->get('/{hash}',[
    'as' => 'home', 'uses' => 'HomeController@showEntry'
]);

$app->get('/json/{hash}',[
    'as' => 'home', 'uses' => 'HomeController@getQuote'
]);

$app->get('/json/next/{hash}',[
    'as' => 'home', 'uses' => 'HomeController@getNextQuote'
]);

$app->get('/json/previous/{hash}',[
    'as' => 'home', 'uses' => 'HomeController@getPreviousQuote'
]);

$app->post('/',[
    'as' => 'home', 'uses' => 'HomeController@saveNewQuote'
]);