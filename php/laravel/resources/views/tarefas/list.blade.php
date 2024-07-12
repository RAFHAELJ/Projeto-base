@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ __('Lista de Tarefas') }}</span>
                    <a href="{{ url('/tarefas/new') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Nova Tarefa 
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="list-group">
                        @foreach ($tarefas as $tarefa)
                            <a href="{{ url('/tarefas/' . $tarefa->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#e9ecef' }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $tarefa->title }}</h5>
                                    </div>
                                    <div class="me-3">
                                        <p class="mb-1">{{ $tarefa->description }}</p>
                                    </div>
                                    <div class="me-3">
                                        <small>Prazo: {{ $tarefa->days ?? 'Sem prazo' }} dias</small>
                                    </div>
                                    <div class="me-3" style="width: 20%;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $tarefa->percentage }}%;" aria-valuenow="{{ $tarefa->percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $tarefa->percentage }}%</div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $tarefa->is_completed ? 'success' : 'warning' }}">{{ $tarefa->is_completed ? 'Concluída' : 'Pendente' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($tarefas->isEmpty())
                        <div class="alert alert-info text-center mt-4">
                            Nenhuma tarefa encontrada.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
