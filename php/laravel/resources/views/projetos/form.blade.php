@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('projetos') }}" class="btn btn-secondary btn-sm">Voltar</a>
                </div>

                <div class="card-body">
                    <h1>{{ Request::is('*/edit') ? 'Editar Projeto' : 'Novo Projeto' }}</h1>
                    
                    <form action="{{ Request::is('*/edit') ? url('/projetos/'.$projeto->id.'/update') : url('projetos/store') }}" method="post">
                        @csrf
                        @if (Request::is('*/edit'))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="name">Nome do Projeto:</label>
                            <input type="text" name="name" class="form-control" value="{{ Request::is('*/edit') ? $projeto->name : old('name') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="sector">Setor:</label>
                            <input type="text" name="sector" class="form-control" value="{{ Request::is('*/edit') ? $projeto->sector : old('sector') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea name="description" class="form-control">{{ Request::is('*/edit') ? $projeto->description : old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="deadline_until">Prazo de Conclusão:</label>
                            <input type="date" name="deadline_until" class="form-control" value="{{ Request::is('*/edit') ? $projeto->deadline_until : old('deadline_until') }}" />
                        </div>

                        <button type="submit" class="btn btn-primary">{{ Request::is('*/edit') ? 'Atualizar' : 'Cadastrar' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
