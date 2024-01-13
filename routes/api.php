<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/get-pincode',function(){
    $json = Storage::disk('local')->get('/public/pincode.json');
    $pincodes = json_decode($json, true);
    return $pincodes;
});


Route::post('/login', [AuthController::class,'loginApi']);

Route::post('/users', [ApiAuthController::class,'index'])->middleware(['auth:api']);
