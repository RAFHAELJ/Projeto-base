@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('tarefas') }}" class="btn btn-secondary btn-sm">Voltar</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>{{ Request::is('*/edit') ? 'Editar Tarefa' : 'Nova Tarefa' }}</h1>
                    
                    <form action="{{ Request::is('*/edit') ? url('/tarefas/'.$tarefas->id.'/update') : url('tarefas/store') }}" method="post">
                        @csrf
                        @if (Request::is('*/edit'))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="title">Nome da Atividade:</label>
                            <input type="text" name="title" class="form-control" value="{{ Request::is('*/edit') ? $tarefas->title : old('title') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição da Atividade:</label>
                            <textarea name="description" class="form-control" required>{{ Request::is('*/edit') ? $tarefas->description : old('description') }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="days">Prazo:</label>
                                <input type="number" name="days" class="form-control" maxlength="3" value="{{ Request::is('*/edit') ? $tarefas->days : old('days') }}" required />
                            </div>

                            <div class="form-group col-md-9">
                                <label for="project_id">Projeto:</label>
                                <select name="project_id" class="form-control" required>
                                    <option value="">Selecione um projeto</option>
                                    @if(isset($projetos) && count($projetos) > 0)
                                        @foreach ($projetos as $projeto)
                                            <option value="{{ $projeto->id }}" {{ Request::is('*/edit') && $projeto->id == $tarefas->project_id ? 'selected' : '' }}>
                                                {{ $projeto->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>                       

                        <button type="submit" class="btn btn-primary">{{ Request::is('*/edit') ? 'Atualizar' : 'Cadastrar' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
