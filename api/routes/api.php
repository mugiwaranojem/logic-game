<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\MoveController;

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


Route::post('/execute', [GameController::class, 'executeRound']);
Route::post('/analyse', [GameController::class, 'analyse']);

Route::get('/config', [ConfigController::class, 'getConfig']);
Route::post('/config/update', [ConfigController::class, 'updateConfig']);

Route::get('/moves', [MoveController::class, 'all']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
