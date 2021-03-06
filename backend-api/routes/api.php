<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TodoController;

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

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/todo', [TodoController::class, 'index']);
    Route::post('/todo', [TodoController::class, 'create']);
    Route::put('/todo', [TodoController::class, 'update']);
    Route::delete('/todo/{id}', [TodoController::class, 'delete']);
    Route::get('/todo/search/{date}', [TodoController::class, 'search']);

    Route::get('/user/profil', [UserController::class, 'profil']);
    Route::put('/user/profil', [UserController::class, 'update']);
    Route::get('/user/logout', [UserController::class, 'logout']);
});
