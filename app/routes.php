<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');
//Session routes
Route::get('/logout', array(
    'as' => 'logout',
    'uses' => 'SessionController@destroy'
));
Route::resource('session', 'SessionController');
//All admin routes filtered with auth
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
	Route::resource('article', 'ArticleController');
    // User, Profile and Author functions dealt with by UserController
    Route::get('user', array(
        'as' => 'user.index',
        'uses' => 'UserController@index'
    ));
    Route::get('user/create', array(
        'as' => 'user.create',
        'uses' => 'UserController@create'
    ));
    Route::post('user', array(
        'as' => 'user.store',
        'before' => 'csrf',
        'uses' => 'UserController@store'
    ));
    Route::get('user/resetpassword', array(
        'as' => 'user.getpasswordreset',
        'uses' => 'UserController@showPasswordReset'
    ));
    Route::get('user/{id}', array(
        'as' => 'user.show',
        'uses' => 'UserController@showProfileForm'
    ));
    Route::get('user/{id}/edit', array(
        'as' => 'user.edit',
        'uses' => 'UserController@edit'
    ));
    Route::put('user/{id}', array(
        'as' => 'user.update',
        'before' => 'csrf',
        'uses' => 'UserController@update'
    ));
    Route::put('user/{id}/updaterole', array(
        'as' => 'user.updaterole',
        'before' => 'csrf',
        'uses' => 'UserController@updateUserRole'
    ));
    Route::put('user/{id}/resetpassword', array(
        'as' => 'user.resetpassword',
        'before' => 'csrf',
        'uses' => 'UserController@resetUserPassword'
    ));
    Route::delete('user/{id}', array(
        'as' => 'user.destroy',
        'before' => 'csrf',
        'uses' => 'UserController@destroy'
    ));
    // Category routes
    Route::resource('category', 'CategoryController');
    //ajax image uploads
    Route::post('profileimageupload', array(
        'as' => 'ajax.profileimage',
        'uses' => 'AuthorController@setProfileImage'
    ));
    Route::post('contentimageupload', array(
        'as' => 'ajax.contentimage',
        'uses' => 'ContentImageController@store'
    ));
});

Route::get('/{slug}', 'HomeController@showArticle');
