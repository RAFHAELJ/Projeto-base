<?php

namespace App\Repositories;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Tarefas;


class TarefasRepository{
  
    public function index(){
        $usuarios = Tarefas::get();
        
        return $usuarios;
    }

    public function new(){
        return view('usuarios.form');
    }

    public function create(Request $request){
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $tarefa = new Tarefas;
        $tarefas = $tarefa->create($data);
        return $tarefas;
    }
    public function find($id){
        $tarefa= Tarefas::find($id);
        return $tarefa;
    }
    public function edit($id){
        $tarefa = Tarefas::with('subtarefas')->find($id);
        return $tarefa;
    }

    public function update($id, Request $request){
        $tarefa= Tarefas::find($id);
        $tarefas = $tarefa->update($request->all());
        return $tarefas;
    }

    public function delete($id){
        $tarefas= Tarefas::find($id);
        $tarefas -> delete();
        return $tarefas;
    }
}
