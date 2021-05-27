<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {

    // Module User
    Route::prefix('users')->group(function () {
        // Danh sách User
        Route::get('/', [UserController::class, 'index'])->name('user.index'); // Thêm định danh, modulle.function
        // Thêm User
        Route::get('/create', [UserController::class, 'create'])->name('user.add');
        Route::post('/create', [UserController::class, 'store'])->name('user.store');

        // Sửa User
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/edit/{id}', [UserController::class, 'update'])->name('user.update');

        // Xóa User
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });

    // Module Role
    Route::prefix('roles')->group(function () {
        // Danh sách User
        Route::get('/', [RoleController::class, 'index'])->name('role.index'); // Thêm định danh, modulle.function
        // Thêm Role
        Route::get('/create', [RoleController::class, 'create'])->name('role.add');
        Route::post('/create', [RoleController::class, 'store'])->name('role.store');

        // Sửa Role
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/edit/{id}', [RoleController::class, 'update'])->name('role.update');

        // Xóa Role
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });

});



