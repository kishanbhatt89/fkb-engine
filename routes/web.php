<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::middleware(['auth','role:admin'])->name('admin.')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/table', [UserController::class, 'table'])->name('users.table');
    Route::resource('/users', UserController::class);
    
    
    Route::delete('roles/destroyMultiple', [RoleController::class, 'destroyMultiple'])->name('roles.destroyMultiple');
    Route::get('/roles/{role}/details', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/table', [RoleController::class, 'table'])->name('roles.table');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');    
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    //Route::resource('/roles', RoleController::class);
    Route::delete('permissions/destroyMultiple', [PermissionController::class, 'destroyMultiple'])->name('permissions.destroyMultiple');
    Route::get('/permissions/{permission}/details', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/permissions/table', [PermissionController::class, 'table'])->name('permissions.table');
    
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');    
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

});




