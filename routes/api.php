<?php

use App\Enums\PermissionEnum;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationApiController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

Route::prefix('auth')->group(function (): void {
    Route::post('/login', [AuthenticationApiController::class, 'login']);
    Route::post('/logout', [AuthenticationApiController::class, 'logout']);
});

JsonApiRoute::server('v1')->prefix('v1')->resources(function (ResourceRegistrar $server) {
    $server->resource('users', JsonApiController::class);
});

Route::prefix('v1/users')->group(function () {
    Route::patch('/{user}/roles', [UserRoleController::class, 'assignRoles'])
        ->middleware(['auth:sanctum', 'permission:assign-roles-user']);
});