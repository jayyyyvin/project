<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/verify', [UserController::class, 'verifyOTP']);
Route::get('/users', [UserController::class, 'users']);
Route::post('/create', [UserController::class, 'store']);
Route::delete('delete/{id}', [UserController::class, 'destroy']);
Route::post('update/{id}', [UserController::class, 'update']);
Route::get('getUser/{id}', [UserController::class, 'getUser']);
Route::get('/myUser',[UserController::class, 'profile'])->middleware('auth:sanctum');



