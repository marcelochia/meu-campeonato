<?php

use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
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

Route::apiResource('times', TeamController::class)->parameters(['times' => 'team']);
Route::apiResource('campeonatos', ChampionshipController::class)->parameters(['campeonatos' => 'championship']);
