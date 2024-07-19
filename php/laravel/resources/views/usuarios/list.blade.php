@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Lista de Usuários') }}</h5>
                    <a href="{{ url('/usuarios/new') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-user-plus"></i> Novo Usuário
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <th scope="row">{{ $usuario->id }}</th>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <a href="/usuarios/{{ $usuario->id }}/edit" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="usuarios/{{ $usuario->id }}/delete" method="post" style="display:inline;">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este usuário?');">
                                            <i class="fas fa-trash"></i> Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .btn-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-Ku2nbjG4ttzz7gB9z7N9jjTp6SJSNzR0N5W//kP8vH9tKcJvAlI60G3t/yfOl8cSkbrk8vjHULCdwIrO3HcRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
