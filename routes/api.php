<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('article', [ArticleController::class, 'index']);
Route::group(['prefix' => 'dataset'], function() {
    Route::get('source', [DatasetController::class, 'getSources']);
    Route::get('preference', [DatasetController::class, 'getPreferences']);
});
Route::group(['middleware' => ['auth:sanctum:users']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('user-update', [UserController::class, 'update']);
    Route::post('save-preference', [UserPreferenceController::class, 'save']);
    
});
