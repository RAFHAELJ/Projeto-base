@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ __('Controle de Afazeres') }}</span>
                    <span>{{ Auth::user()->name }}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h1 class="mb-4 text-center">Seja Bem-vindo!</h1>
                    <div class="d-grid gap-2">
                        <a href="{{ url('/usuarios') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-users me-2"></i> Lista dos Usuários
                        </a>
                        <a href="{{ url('/projetos') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-tasks me-2"></i> Lista Projetos
                        </a>
                        <a href="{{ url('/subtarefas') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-tasks me-2"></i> Lista Sub Tarefas
                        </a>
                        <a href="{{ url('/tarefas') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-tasks me-2"></i> Lista das Tarefas
                        </a>
                    </div>
                </div>
            </div>

            <div id="notifications" class="mt-4"></div> <!-- Nova div para notificações -->
        </div>
    </div>
  
</div>


@endsection

@push('styles')
<style>
    .chat-container {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 30%;
        height: 70%;
        border: 1px solid #ccc;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .chat-input {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ccc;
    }

    .chat-input textarea {
        flex: 1;
        resize: none;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .chat-input button {
        margin-left: 10px;
        padding: 10px 15px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .chat-input button:hover {
        background-color: #218838;
    }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Escute os eventos de mensagem recebida no Laravel Echo
    
    window.Echo.channel('user.{{ Auth::user()->id }}')
        .listen('.SendMessage', (e) => {
            console.log('Mensagem recebida:', e.message);
        });
</script>
@endpush
