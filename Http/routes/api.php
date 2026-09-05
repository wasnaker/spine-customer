<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| ROUTE MODUL Customer (konvensi core: api/v1 + auth:sanctum)
|--------------------------------------------------------------------------
| Middleware permission:feature:capability (gate per aksi).
| Modul ini tidak expose endpoint Vat — lihat spine-vat untuk itu.
|
|   /api/v1/customers
|     GET    /                              customer:view
|     POST   /                              customer:create
|     GET    /{id}                          customer:view
|     PUT    /{id}                          customer:edit
|     DELETE /{id}                          customer:delete
||     GET    /{id}/activity-logs            customer:view
|*/

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->middleware('permission:customer:view|customer:view-connected');
        Route::post('/', [CustomerController::class, 'store'])->middleware('permission:customer:create');
        Route::get('/{id}', [CustomerController::class, 'show'])->whereNumber('id')->middleware('permission:customer:view|customer:view-connected');
        Route::put('/{id}', [CustomerController::class, 'update'])->whereNumber('id')->middleware('permission:customer:edit');
        Route::get('/{id}/activity-logs', [CustomerController::class, 'activityLogs'])->whereNumber('id')->middleware('permission:customer:view|customer:view-connected');
        Route::get('/{id}/branches', [CustomerController::class, 'branches'])->whereNumber('id')->middleware('permission:branch:view|customer:view-connected');
        Route::get('/{id}/pengawas', [CustomerController::class, 'pengawas'])->whereNumber('id')->middleware('permission:pengawas:assign|customer:view|customer:view-connected');
        Route::put('/{id}/pengawas', [CustomerController::class, 'assignPengawas'])->whereNumber('id')->middleware('permission:pengawas:assign');
        Route::get('/{id}/staffs', [CustomerController::class, 'staffs'])->whereNumber('id')->middleware('permission:customer:view|customer:view-connected');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->whereNumber('id')->middleware('permission:customer:delete');
    });
});
