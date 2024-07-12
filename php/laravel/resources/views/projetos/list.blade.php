@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ __('Lista de Projetos') }}</span>
                    <a href="{{ url('/projetos/new') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Novo Projeto
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
                                    <th scope="col">Nome</th>
                                    <th scope="col">Setor</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Prazo</th>
                                    <th scope="col" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projetos as $projeto)
                                <tr>
                                    <th scope="row">{{ $projeto->id }}</th>
                                    <td>{{ $projeto->name }}</td>
                                    <td>{{ $projeto->sector }}</td>
                                    <td>{{ $projeto->description }}</td>
                                    <td>{{ $projeto->deadline_until ?? 'Sem prazo' }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/projetos/' . $projeto->id . '/edit') }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ url('/projetos/' . $projeto->id . '/delete') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este projeto?')">
                                                <i class="fas fa-trash"></i> Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($projetos->isEmpty())
                        <div class="alert alert-info text-center mt-4">
                            Nenhum projeto encontrado.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection