<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

    });
});



