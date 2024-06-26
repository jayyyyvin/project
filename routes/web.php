<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'home']);
Route::get('/create-user', [HomeController::class, 'createUser']);
Route::get('/showuser', [HomeController::class, 'showUser']);
Route::get('/edituser/{id}', [HomeController::class, 'editUser']);
Route::get('/profile', [HomeController::class, 'getUser']);



