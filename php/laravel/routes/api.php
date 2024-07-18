<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MessageController;

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
Route::middleware('auth:api')->group(function () {
    Route::post('/messages/unread-count/{userId}', [MessageController::class, 'unreadCount']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/{userId}', [MessageController::class, 'index']);
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    Route::get('/invoke-lambda', [LambdaServiceController::class, 'invokeLambdaFunction']);
});
Route::middleware('auth:api')->get('/current-user', function () {
    return response()->json(Auth::user());
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
