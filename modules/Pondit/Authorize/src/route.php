<?php

use Pondit\Authorize\Controllers\PermissionsController;
Route::group([
    'prefix' => Config("authorization.route-prefix"),
    'namespace' => 'Pondit\Authorize\Controllers',
    'middleware' => ['web', 'auth']],
    function() {
    Route::group(['middleware' => Config("authorization.middleware")], function() {
        Route::resource('users', UsersController::class, ['except' => [
            'create', 'store', 'show'
        ]]);

        Route::resource('roles',    RolesController::class);
        Route::get('/permissions',  [PermissionsController::class,'index']);
        Route::post('/permissions', [PermissionsController::class,'update']);
        Route::post('/permissions/getSelectedRoutes', [PermissionsController::class, 'getSelectedRoutes']);
    });

    Route::get('/', function () {
        return view('vendor.authorize.welcome');
    });
});