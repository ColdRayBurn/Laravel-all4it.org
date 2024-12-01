<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomepageController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\GlobalInfoController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PrivacyController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//api
Route::prefix('v1')->group(function () {
    // Открытые маршруты
    Route::get('/globals', [GlobalInfoController::class, 'index']);
	Route::get('/homepage', [HomepageController::class, 'index']);
    Route::get('/projects', [PortfolioController::class, 'index']);
    Route::get('/projects/{id}', [PortfolioController::class, 'show']);
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/privacy', [PrivacyController::class, 'show']);

    //POST запросы
    Route::post('/feedback', [FeedbackController::class, 'store']);


    // Защищенные маршруты требующие аутентификации
    Route::middleware('auth:sanctum')->group(function () {

    });
});
