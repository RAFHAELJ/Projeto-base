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

Route::get('/oauth/csrf', function () {
    return [];
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Route::middleware('auth:web')->group(function () {
    Broadcast::routes();
});
Route::middleware(['auth'])->group(function(){

    Route::get('/users', [App\Http\Controllers\UsersController::class, 'indexChat']);
    Route::get('/usuarios', [App\Http\Controllers\UsersController::class, 'index']);
    Route::get('/usuarios/new', [App\Http\Controllers\UsersController::class, 'new']);
    Route::get('/usuarios/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit']);
    Route::post('/usuarios/add', [App\Http\Controllers\UsersController::class, 'add']);
    Route::put('/usuarios/{id}/update', [App\Http\Controllers\UsersController::class, 'update']);
    Route::delete('/usuarios/{id}/delete', [App\Http\Controllers\UsersController::class, 'destroy']);

    Route::get('/tarefas', [App\Http\Controllers\TarefasController::class, 'index']);    
    Route::get('/tarefas/new', [App\Http\Controllers\TarefasController::class, 'new']);
    Route::get('/tarefas/{id}', [App\Http\Controllers\TarefasController::class, 'show']);
    Route::get('/tarefas/{id}/edit', [App\Http\Controllers\TarefasController::class, 'edit']);
    Route::post('/tarefas/store', [App\Http\Controllers\TarefasController::class, 'store']);
    Route::put('/tarefas/{id}/update', [App\Http\Controllers\TarefasController::class, 'update']);
    Route::delete('/tarefas/{id}', [App\Http\Controllers\TarefasController::class, 'destroy'])->name('tarefas.destroy');

    Route::get('/tarefasTpl/template', [App\Http\Controllers\TarefasController::class, 'generateTemplate'])->name('tarefasTpl.template');
    Route::post('/tarefasTpl/upload', [App\Http\Controllers\TarefasController::class, 'upload'])->name('tarefasTpl.upload');

    Route::get('/projetos', [App\Http\Controllers\ProjetoController::class, 'index']);    
    Route::get('/projetos/new', [App\Http\Controllers\ProjetoController::class, 'new']);
    Route::get('/projetos/{id}', [App\Http\Controllers\ProjetoController::class, 'show']);
    Route::get('/projetos/{id}/edit', [App\Http\Controllers\ProjetoController::class, 'edit']);
    Route::post('/projetos/store', [App\Http\Controllers\ProjetoController::class, 'store']);
    Route::put('/projetos/{id}/update', [App\Http\Controllers\ProjetoController::class, 'update']);
    Route::delete('/projetos/{id}/delete', [App\Http\Controllers\ProjetoController::class, 'destroy']);

    Route::get('/subtarefas', [App\Http\Controllers\SubTarefasController::class, 'index']);
    Route::get('/subtarefas/new/{tarefa_id}', [App\Http\Controllers\SubTarefasController::class, 'new']);    
    Route::get('/subtarefas/{id}/edit', [App\Http\Controllers\SubTarefasController::class, 'edit']);
    Route::post('/subtarefas/{id}/concluir', [App\Http\Controllers\SubTarefasController::class, 'concluir']);
    Route::post('/subtarefas/store/{tarefa_id}', [App\Http\Controllers\SubTarefasController::class, 'store']);
    Route::put('/subtarefas/{id}/update', [App\Http\Controllers\SubTarefasController::class, 'update'])->name('subtarefas.update');
    Route::delete('/subtarefas/{id}/delete', [App\Http\Controllers\SubTarefasController::class, 'destroy'])->name('subtarefas.destroy');

    
    Route::get('/messages/unread-count/{userId}', [App\Http\Controllers\MessageController::class, 'unreadCount']);
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store']);
    Route::get('/messages/{userId}', [App\Http\Controllers\MessageController::class, 'index']);
    Route::post('/send-message', [App\Http\Controllers\MessageController::class, 'sendMessage']);
    Route::get('/invoke-lambda', [App\Http\Controllers\LambdaServiceController::class, 'invokeLambdaFunction']);
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');;
    
   
});
Route::get('/current-user', function () {
    return Auth::user();
});

Route::post('/py/messages', [App\Http\Controllers\MessageController::class, 'store']);


Route::get('/phpinfo', function () {
    phpinfo();
});







