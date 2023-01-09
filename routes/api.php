<?php

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
Route::post('register', [App\Http\Controllers\ApiController::class, 'register']);
Route::post('login', [App\Http\Controllers\ApiController::class, 'login']);




/*Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('current', [App\Http\Controllers\ApiController::class, 'current']);
    Route::post('logout', [App\Http\Controllers\ApiController::class, 'logout']);
});*/

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('current', [App\Http\Controllers\ApiController::class, 'current']);
    Route::post('logout', [App\Http\Controllers\ApiController::class, 'logout']);
    Route::get('index', [App\Http\Controllers\ApiController::class, 'index']);
    Route::post('messages', [App\Http\Controllers\ApiController::class, 'messages']);
    Route::post('send', [App\Http\Controllers\ApiController::class, 'send']);
});
