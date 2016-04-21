<?php

/**
 * --------------------------------------------------------------------------
 *  Routes File
 * --------------------------------------------------------------------------
 *
 * Here is where you will register all of the routes in an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 */

Route::group(['middleware' =>[ 'web']], function () {

    Route::get('/', 'HomeController@index');

    Route::any('/login', 'HomeController@login');

    /**
     * --------------------------------------------------------------------------
     *  User Related routes
     */
    Route::any('/user-agreement/signature', 'UserController@termsAgreementSignature');
    Route::any('/user-agreement', 'UserController@termsAgreement');


    /**
     * --------------------------------------------------------------------------
     *  Intranet - admin (public)
     */
    Route::group(['namespace' => 'Intranet'], function()
    {
        Route::any('/intranet', function() {
            return redirect(config('app.url-gai').'/login');
        });

        // Login / Logout
        Route::any('/intranet/login', 'DefaultController@login');
        Route::any('/intranet/logout', 'DefaultController@logout');

    });
    
    /**
     * --------------------------------------------------------------------------
     *  Intranet - admin (private)
     */
    Route::group(['namespace' => 'Intranet','middleware' =>[ 'intranetauth']], function()
    {
        // Dashboard
        Route::any('/intranet/dashboard', 'DashboardController@index');
        // Agents
        Route::any('/intranet/agents/form', 'AgentsController@formAgent');
        Route::any('/intranet/agents/form/{id?}', 'AgentsController@formAgent');
        Route::any('/intranet/agents/delete/{id}', 'AgentsController@deleteAgent');
        Route::any('/intranet/agents/{type?}', 'AgentsController@index');

        // Users
        Route::any('/intranet/users/form', 'UsersController@formUser');
        Route::any('/intranet/users/form/{id?}', 'UsersController@formUser');
        Route::any('/intranet/users/delete/{id}', 'UsersController@deleteUser');
        Route::any('/intranet/users/{type?}', 'UsersController@index');

        // Offices
        Route::any('/intranet/offices/form', 'OfficesController@formOffices');
        Route::any('/intranet/offices/form/{id?}', 'OfficesController@formOffices');
        Route::any('/intranet/offices/delete/{id}', 'OfficesController@deleteOffice');
        Route::any('/intranet/offices/main/{id?}', 'OfficesController@infoOffices');
        Route::any('/intranet/offices/{type?}', 'OfficesController@index');   
        


    });
});
