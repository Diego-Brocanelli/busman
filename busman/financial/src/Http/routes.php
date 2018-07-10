<?php

Route::group([
    'namespace' => 'Busman\Accounting\Http\Controllers',
    'middleware' => ['auth:api', 'bindings'],
    'prefix' => config('accounting.routes.prefix')
], function () {

    /*
    |--------------------------------------------------------------------------------
    | Role management routes
    |--------------------------------------------------------------------------------
    */
    Route::apiResource('roles', 'RoleController');
    Route::get('permissions', 'RoleController@permissionGroups');

});
