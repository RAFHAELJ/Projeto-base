@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ $tarefa->title }}</span>
                    <a href="{{ url('/tarefas') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center bg-light p-3 mb-4 rounded">
                        <p class="mb-0"><strong>Descrição:</strong> {{ $tarefa->description }}</p>
                        <p class="mb-0"><strong>Prazo:</strong> {{ $tarefa->days ?? 'Sem prazo' }} dias</p>
                        <p class="mb-0"><strong>Status:</strong> {{ $tarefa->is_completed ? 'Concluída' : 'Pendente' }}</p>
                    </div>

                    <h4 class="mt-4">Subtarefas</h4>
                    @if($subtarefas->isEmpty())
                        <div class="alert alert-info text-center">
                            Nenhuma subtarefa encontrada.
                        </div>
                    @else
                        <div class="row">
                            @foreach ($subtarefas as $subtarefa)
                                <div class="col-md-4">
                                    <div class="card mb-3 shadow {{ $subtarefa->is_completed ? 'bg-success text-white' : '' }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $subtarefa->title }}</h5>
                                            <p class="card-text">{{ $subtarefa->description }}</p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ $subtarefa->is_completed ? 'Concluída' : 'Pendente' }}
                                                </small>
                                            </p>
                                            @if(!$subtarefa->is_completed)
                                                <form action="{{ url('/subtarefas/' . $subtarefa->id . '/concluir') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Marcar como Concluída</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr class="my-4">

                    <a href="{{ url('/subtarefas/new/' . $tarefa->id) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Adicionar Subtarefa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
