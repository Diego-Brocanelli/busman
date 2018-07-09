<?php

Route::group([
    'namespace' => 'Busman\Acl\Http\Controllers',
    'middleware' => ['auth:api', 'bindings'],
    'prefix' => config('acl.routes.prefix')
], function () {

    /*
    |--------------------------------------------------------------------------------
    | Role management routes
    |--------------------------------------------------------------------------------
    */
    Route::apiResource('roles', 'RoleController');
    Route::get('permissions', 'RoleController@permissionGroups');

});
