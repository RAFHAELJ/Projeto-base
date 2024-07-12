@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('tarefas/' . $tarefa->id) }}" class="btn btn-secondary btn-sm">Voltar</a>
                </div>

                <div class="card-body">
                    <h1>{{ Request::is('*/edit') ? 'Editar Subtarefa' : 'Nova Subtarefa' }}</h1>
                    
                    <form action="{{ Request::is('*/edit') ? url('/subtarefas/'.$subtarefa->id.'/update') : url('subtarefas/store/' . $tarefa->id) }}" method="post">
                        @csrf
                        @if (Request::is('*/edit'))
                            @method('PUT')
                        @endif

                        <!-- Campo oculto para task_id -->
                        <input type="hidden" name="task_id" value="{{ $tarefa->id }}">

                        <div class="form-group">
                            <label for="title">Nome da Subtarefa:</label>
                            <input type="text" name="title" class="form-control" value="{{ Request::is('*/edit') ? $subtarefa->title : old('title') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea name="description" class="form-control">{{ Request::is('*/edit') ? $subtarefa->description : old('description') }}</textarea>
                        </div>                    

                        <button type="submit" class="btn btn-primary">{{ Request::is('*/edit') ? 'Atualizar' : 'Cadastrar' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
