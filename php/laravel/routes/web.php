<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TarefasController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\SubTarefasController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LambdaServiceController;
use App\Http\Controllers\NewController;

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

// Public Routes
Route::get('/', [HomeController::class, 'home'])->name('home');

// Authentication Routes
Auth::routes();

// Custom Logout Route
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// OAuth CSRF Route
Route::get('/oauth/csrf', function () {
    return [];
});

// Routes requiring authentication
Route::middleware('auth')->group(function () {
    Broadcast::routes();

    // Home Route
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // User Routes
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::get('/new', [UsersController::class, 'new']);
        Route::get('/{id}/edit', [UsersController::class, 'edit']);
        Route::post('/add', [UsersController::class, 'add']);
        Route::put('/{id}/update', [UsersController::class, 'update']);
        Route::delete('/{id}/delete', [UsersController::class, 'destroy']);
    });
	Route::get('/users', [UsersController::class, 'indexChat']);

    // Task Routes
    Route::prefix('tarefas')->group(function () {
        Route::get('/', [TarefasController::class, 'index']);
        Route::get('/new', [TarefasController::class, 'new']);
        Route::get('/{id}', [TarefasController::class, 'show']);
        Route::get('/{id}/edit', [TarefasController::class, 'edit']);
        Route::post('/store', [TarefasController::class, 'store']);
        Route::put('/{id}/update', [TarefasController::class, 'update']);
        Route::delete('/{id}', [TarefasController::class, 'destroy'])->name('tarefas.destroy');
        Route::get('/Tpl/template', [TarefasController::class, 'generateTemplate'])->name('tarefasTpl.template');
        Route::post('/Tpl/upload', [TarefasController::class, 'upload'])->name('tarefasTpl.upload');
    });

    // Project Routes
    Route::prefix('projetos')->group(function () {
        Route::get('/', [ProjetoController::class, 'index']);
        Route::get('/new', [ProjetoController::class, 'new']);
        Route::get('/{id}', [ProjetoController::class, 'show']);
        Route::get('/{id}/edit', [ProjetoController::class, 'edit']);
        Route::post('/store', [ProjetoController::class, 'store']);
        Route::put('/{id}/update', [ProjetoController::class, 'update']);
        Route::delete('/{id}/delete', [ProjetoController::class, 'destroy']);
    });

    // Subtask Routes
    Route::prefix('subtarefas')->group(function () {
        Route::get('/', [SubTarefasController::class, 'index']);
        Route::get('/new/{tarefa_id}', [SubTarefasController::class, 'new']);
        Route::get('/{id}/edit', [SubTarefasController::class, 'edit']);
        Route::post('/{id}/concluir', [SubTarefasController::class, 'concluir']);
        Route::post('/store/{tarefa_id}', [SubTarefasController::class, 'store']);
        Route::put('/{id}/update', [SubTarefasController::class, 'update'])->name('subtarefas.update');
        Route::delete('/{id}/delete', [SubTarefasController::class, 'destroy'])->name('subtarefas.destroy');
    });

    // Message Routes
    Route::prefix('messages')->group(function () {
        Route::get('/unread-count/{userId}', [MessageController::class, 'unreadCount']);
        Route::post('/', [MessageController::class, 'store']);
        Route::get('/{userId}', [MessageController::class, 'index']);
    });

    // Additional Routes
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    Route::post('/invoke-lambda', [LambdaServiceController::class, 'invokeLambdaFunction']);
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

   
});

// Rotas adicionais fora do grupo autenticado
Route::get('/current-user', function () {
    return Auth::user();
});

Route::post('/py/messages', [MessageController::class, 'store']);

Route::get('/phpinfo', function () {
    phpinfo();
});
