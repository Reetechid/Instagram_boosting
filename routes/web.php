<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoStoryViewerController;
use App\Http\Controllers\InstagramLoginController;

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
Route::get('/auto-story-viewer', [AutoStoryViewerController::class, 'index']);
Route::post('/auto-story-viewer-start', [AutoStoryViewerController::class, 'startAutoStory']);
Route::post('/auto-story-viewer-stop', [AutoStoryViewerController::class, 'stopAutoStory']);
Route::post('/process-targets', [AutoStoryViewerController::class, 'processTargets']);



Route::post('/instagram-login', [InstagramLoginController::class, 'login'])->name('instagram.login');
Route::get('/instagram-login', function () {
    return view('auth.login');
})->name('instagram.login');
