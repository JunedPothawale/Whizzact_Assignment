<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
    return redirect()->to('/login');
});
Route::get('/seed', function () {
    Artisan::call('db:seed --class=UserSeeder');
});

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::view('/signup', 'signup');
    Route::post('/signup', [AuthController::class, 'signUp'])->name('signup');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class,'logOut']);
    Route::view('/dashboard', 'dashboard.index');
    Route::get('/dashboard/user/list', [UserController::class,'listUser']);
    Route::get('/dashboard/user/delete/{id}', [UserController::class,'deleteUser']);
    Route::get('/dashboard/user/update', [UserController::class,'updateUser']);
    Route::post('/dashboard/user/update/{id}', [UserController::class,'updateUser'])->name('updatePost');
    Route::get('/dashboard/user/export', [UserController::class, 'exportExcel']);
});





