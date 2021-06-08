<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\AnswersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::resource('users', UsersController::class)->middleware('auth:sanctum');
Route::resource('surveys', SurveysController::class)->middleware('auth:sanctum');
Route::resource('answers', AnswersController::class)->middleware('auth:sanctum');

Route::get('/answers/survey/{id}',[AnswersController::class,'getMyAnswers'])->middleware('auth:sanctum');

Route::get('/surveys/results/{id}',[SurveysController::class,'results'])->middleware('auth:sanctum');


