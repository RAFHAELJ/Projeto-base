@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ __('Lista de Subtarefas') }}</span>
                    <a href="{{ url('/subtarefas/new') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Nova Subtarefa
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subtarefas as $subtarefa)
                                <tr>
                                    <th scope="row">{{ $subtarefa->id }}</th>
                                    <td>{{ $subtarefa->title }}</td>
                                    <td>{{ $subtarefa->description }}</td>
                                    <td>{{ $subtarefa->is_completed ? 'Concluída' : 'Pendente' }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/subtarefas/' . $subtarefa->id . '/edit') }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ url('/subtarefas/' . $subtarefa->id . '/delete') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta subtarefa?')">
                                                <i class="fas fa-trash"></i> Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($subtarefas->isEmpty())
                        <div class="alert alert-info text-center mt-4">
                            Nenhuma subtarefa encontrada.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
