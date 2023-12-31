<?php

use App\Http\Controllers\ManualBotHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DummyUserController;

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

Route::prefix('bot')->middleware("auth:sanctum")->group(function () {
    Route::get("log", [ManualBotHistoryController::class, "log"]);
    Route::post("run", [ManualBotHistoryController::class, "run"]);
    Route::get("run/info/{id}", [ManualBotHistoryController::class, ""]);
    Route::post("login-insta", [ManualBotHistoryController::class, "loginInsta"]);
    Route::get("check", [ManualBotHistoryController::class, "checkUser"]);
});

Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'showAll']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'create']);
    Route::delete('{id}', [UserController::class, 'remove']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::post('login', [UserController::class, 'login']);
});

Route::prefix('dummy-user')->group(function () {
    Route::get('', [DummyUserController::class, 'showAll']);
    Route::get('{id}', [DummyUserController::class, 'show']);
    Route::post('', [DummyUserController::class, 'create']);
    Route::delete('{id}', [DummyUserController::class, 'remove']);
});
