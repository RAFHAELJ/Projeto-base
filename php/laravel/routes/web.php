<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;
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

Route::group(['middleware' => 'web'], function () {

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Route::middleware(['auth'])->group(function(){

    Route::get('/usuarios', [App\Http\Controllers\UsersController::class, 'index']);
    Route::get('/usuarios/new', [App\Http\Controllers\UsersController::class, 'new']);
    Route::get('/usuarios/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit']);
    Route::post('/usuarios/add', [App\Http\Controllers\UsersController::class, 'add']);
    Route::post('/usuarios/{id}/update', [App\Http\Controllers\UsersController::class, 'update']);
    Route::post('/usuarios/{id}/delete', [App\Http\Controllers\UsersController::class, 'delete']);

    Route::get('/tarefas', [App\Http\Controllers\TarefasController::class, 'index']);
    Route::get('/tarefas/new', [App\Http\Controllers\TarefasController::class, 'new']);
    Route::get('/tarefas/{id}/edit', [App\Http\Controllers\TarefasController::class, 'edit']);
    Route::post('/tarefas/add', [App\Http\Controllers\TarefasController::class, 'add']);
    Route::post('/tarefas/{id}/update', [App\Http\Controllers\TarefasController::class, 'update']);
    Route::post('/tarefas/{id}/delete', [App\Http\Controllers\TarefasController::class, 'delete']);
    Route::get('/invoke-lambda', [App\Http\Controllers\LambdaServiceController::class, 'invokeLambdaFunction']);
});


Route::get('/phpinfo', function () {
    phpinfo();
});


