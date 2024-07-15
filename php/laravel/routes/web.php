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
    Route::get('/tarefas/{id}', [App\Http\Controllers\TarefasController::class, 'show']);
    Route::get('/tarefas/{id}/edit', [App\Http\Controllers\TarefasController::class, 'edit']);
    Route::post('/tarefas/store', [App\Http\Controllers\TarefasController::class, 'store']);
    Route::post('/tarefas/{id}/update', [App\Http\Controllers\TarefasController::class, 'update']);
    Route::post('/tarefas/{id}/delete', [App\Http\Controllers\TarefasController::class, 'delete']);

    Route::get('/projetos', [App\Http\Controllers\ProjetoController::class, 'index']);    
    Route::get('/projetos/new', [App\Http\Controllers\ProjetoController::class, 'new']);
    Route::get('/projetos/{id}', [App\Http\Controllers\ProjetoController::class, 'show']);
    Route::get('/projetos/{id}/edit', [App\Http\Controllers\ProjetoController::class, 'edit']);
    Route::post('/projetos/store', [App\Http\Controllers\ProjetoController::class, 'store']);
    Route::post('/projetos/{id}/update', [App\Http\Controllers\ProjetoController::class, 'update']);
    Route::post('/projetos/{id}/delete', [App\Http\Controllers\ProjetoController::class, 'delete']);

    Route::get('/subtarefas', [App\Http\Controllers\SubTarefasController::class, 'index']);
    Route::get('/subtarefas/new/{tarefa_id}', [App\Http\Controllers\SubTarefasController::class, 'new']);    
    Route::get('/subtarefas/{id}/edit', [App\Http\Controllers\SubTarefasController::class, 'edit']);
    Route::post('/subtarefas/{id}/concluir', [App\Http\Controllers\SubTarefasController::class, 'concluir']);
    Route::post('/subtarefas/store/{tarefa_id}', [App\Http\Controllers\SubTarefasController::class, 'store']);
    Route::post('/subtarefas/{id}/update', [App\Http\Controllers\SubTarefasController::class, 'update']);
    Route::post('/subtarefas/{id}/delete', [App\Http\Controllers\SubTarefasController::class, 'delete']);

    Route::post('/send-message', [App\Http\Controllers\MessageController::class, 'sendMessage']);
    Route::get('/invoke-lambda', [App\Http\Controllers\LambdaServiceController::class, 'invokeLambdaFunction']);
});

Route::get('/chat', function () {
    return view('chat');
});
Route::get('/phpinfo', function () {
    phpinfo();
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
