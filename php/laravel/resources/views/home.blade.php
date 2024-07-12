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
                        <a href="{{url("/usuarios")}}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-users me-2"></i> Lista dos Usuários
                        </a>
                        <a href="{{url("/projetos")}}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-tasks me-2"></i> Lista Projetos
                        </a>
                        <a href="{{url("/subtarefas")}}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-tasks me-2"></i> Lista Sub Tarefas
                        </a>
                        <a href="{{url("/tarefas")}}" class="btn btn-outline-success btn-lg">
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

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
  window.Echo.channel('tarefas')
    .listen('TarefaAtrasada', (e) => {
        console.log(e.message);
    });
</script>
@endpush
