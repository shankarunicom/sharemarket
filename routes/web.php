<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Angelbroking;
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

Route::get('/user', [UserController::class, 'index']);
Route::get('/add-user', [UserController::class, 'create']);
Route::get('/add-user/{id}', [UserController::class, 'create']);
Route::get('/download-profile/{id}', [UserController::class, 'downloadProfile']);
Route::get('/remove-user/{id}', [UserController::class, 'remove']);
Route::any('/save-user', [UserController::class, 'save']);
Route::any('/get-meta-data', [UserController::class, 'getMetaData']);
Route::any('/angelbroking', [Angelbroking::class, 'index']);
