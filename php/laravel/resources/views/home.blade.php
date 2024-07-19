@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">{{ __('Controle de Afazeres') }}</h4>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center mb-5">
                        <h1 class="display-4 mb-3">Seja Bem-vindo!</h1>
                        <p class="lead">Gerencie seus projetos e tarefas de maneira eficiente e organizada.</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <a href="{{ url('/usuarios') }}" class="text-decoration-none">
                                <div class="card text-center border-0 shadow-sm hover-shadow">
                                    <div class="card-body py-5">
                                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                                        <h5 class="card-title">Lista dos Usuários</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url('/projetos') }}" class="text-decoration-none">
                                <div class="card text-center border-0 shadow-sm hover-shadow">
                                    <div class="card-body py-5">
                                        <i class="fas fa-project-diagram fa-3x mb-3 text-success"></i>
                                        <h5 class="card-title">Lista Projetos</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ url('/tarefas') }}" class="text-decoration-none">
                                <div class="card text-center border-0 shadow-sm hover-shadow">
                                    <div class="card-body py-5">
                                        <i class="fas fa-tasks fa-3x mb-3 text-warning"></i>
                                        <h5 class="card-title">Lista das Tarefas</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
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
    .container {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        border-bottom: none;
    }

    .card-title {
        font-weight: 600;
    }

    .hover-shadow:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.3s ease-in-out;
    }

    .display-4 {
        font-weight: 700;
        color: #2c3e50;
    }

    .lead {
        font-size: 1.25rem;
        color: #34495e;
    }
</style>
@endpush

