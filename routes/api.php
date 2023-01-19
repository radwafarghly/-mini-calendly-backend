<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleDayController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me/{user}', 'me');
});

Route::middleware('auth:api')->group(function () {
    /*Schedule api*/
    Route::apiResource('schedule', ScheduleController::class);
    /*Schedule Day api*/
    Route::post('schedule/assgin/day/{schedule}', [ScheduleDayController::class, 'assginDayToSchedule']);
    Route::post('schedule/delete/day/{schedule}', [ScheduleDayController::class, 'deleteDayToSchedule']);
    /* Event Api */
    Route::apiResource('event', EventController::class);

});
