<?php

Route::group([
    'middleware' => ['auth:api', 'bindings'],
    'prefix' => config('people.routes.prefix')
], function() {

    /*
    |--------------------------------------------------------------------------------
    | People management routes
    |--------------------------------------------------------------------------------
    */
    // Return the logged user information
    Route::get('/user', 'Busman\People\Http\Controllers\UserController@current');
    Route::put('/user/last-read-announcements-at', 'Busman\People\Http\Controllers\UserController@updateLastReadAnnouncementsTimestamp');
    Route::post('/user/switch-to-team/{team}', 'Busman\People\Http\Controllers\UserController@switchCurrentTeam');

    // Base user types
    Route::apiResource('/employees', 'Busman\People\Http\Controllers\EmployeeController');
    Route::apiResource('/customers', 'Busman\People\Http\Controllers\CustomerController');
    Route::apiResource('/teams', 'Busman\People\Http\Controllers\TeamController');
    Route::put('/reset-password', 'Busman\People\Http\Controllers\PasswordController@update');

    // Settings
    Route::post('/language/switch', 'Busman\People\Http\Controllers\UserController@switchLang');
});
