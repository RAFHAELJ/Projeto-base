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
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title">{{ $subtarefa->title }}</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-muted" type="button" id="dropdownMenuButton{{ $subtarefa->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $subtarefa->id }}">
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $subtarefa->id }}">
                                                                Editar
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('subtarefas.destroy', $subtarefa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta subtarefa?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Excluir</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
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

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $subtarefa->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $subtarefa->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $subtarefa->id }}">Editar Subtarefa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('subtarefas.update', $subtarefa->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="title{{ $subtarefa->id }}" class="form-label">Título</label>
                                                        <input type="text" class="form-control" id="title{{ $subtarefa->id }}" name="title" value="{{ $subtarefa->title }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description{{ $subtarefa->id }}" class="form-label">Descrição</label>
                                                        <textarea class="form-control" id="description{{ $subtarefa->id }}" name="description" rows="3" required>{{ $subtarefa->description }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                                                </form>
                                            </div>
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
