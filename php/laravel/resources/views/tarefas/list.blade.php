@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"><a href="{{url("/tarefas/new")}}">Novo Usuário</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Lista de atividades </h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titutlo</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarefas as $tarefa)
                          <tr>
                            <th scope="row">{{$tarefa->id}}</th>
                            <td>{{$tarefa->title}}</td>
                            <td>{{$tarefa->description}}</td>
                            <td>
                            <a href="/tarefas/{{ $tarefa->id }}/edit" class="btn btn-info">EDITAR</a>
                            <form action="tarefas/{{ $tarefa->id }}/delete" method="post">
                                @csrf
                                @method('post')
                                <button class="btn btn-danger">DELETAR</button>
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
