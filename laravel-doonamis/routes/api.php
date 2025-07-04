<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;
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


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);

    Route::resource('usuarios', UsuariosController::class);
    Route::post('usuarios/import-csv', [UsuariosController::class, 'importCsv']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


