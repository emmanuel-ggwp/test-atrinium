<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\RoleAppealController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationApiController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use LaravelJsonApi\Laravel\Routing\Relationships;

Route::prefix('auth')->group(function (): void {
    Route::post('/login', [AuthenticationApiController::class, 'login']);
    Route::post('/logout', [AuthenticationApiController::class, 'logout']);
});

JsonApiRoute::server('v1')->prefix('v1')->resources(function (ResourceRegistrar $server) {
    $server->resource('users', JsonApiController::class);
    $server->resource('companies', CompanyController::class)->relationships(function (Relationships $relations) {
        $relations->hasOne('owner')->readOnly();
        $relations->hasMany('activityTypes')->readOnly();
    });
});

Route::prefix('v1/users')->middleware('auth:sanctum')->group(callback: function () {
    Route::prefix('role-appeal')->group(function () {
        Route::post('', [RoleAppealController::class, 'store']);
        Route::post('/{roleAppeal}/resolve', [RoleAppealController::class, 'resolve'])
            ->middleware(['permission:resolve-role-appeal']);
    });


    Route::patch('/{user}/roles', [UserController::class, 'assignRoles'])
        ->middleware(['permission:assign-roles-user']);
});