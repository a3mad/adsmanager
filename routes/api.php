<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DigitalReportController;
use App\Http\Controllers\RequestedReportController;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('programs', [ProgramController::class, 'index']);
        Route::get('reports', [ReportController::class, 'index']);
        Route::get('digital-reports', [DigitalReportController::class, 'index']);
        Route::get('requested-reports', [RequestedReportController::class, 'index']);
    });

});
