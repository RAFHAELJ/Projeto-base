<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Repositories\TarefasRepository;

class TarefasController extends Controller
{
    public function __construct(TarefasRepository $repository){
        $this->repository = $repository;
    }
    public function index(){
        $tarefas =  $this->repository->index();
        
        return \view('tarefas.list', ['tarefas'=>$tarefas]);
    }

    public function new(){
        return view('tarefas.form');
    }

    public function add(Request $request){
        $tarefa =  $this->repository->add($request);
        return Redirect::to('/tarefas');
    }

    public function edit($id){
        $tarefa =  $this->repository->edit($id);
        return view('tarefas.form', ['tarefa'=>$tarefa]);
    }

    public function update($id, Request $request){
        $tarefa =  $this->repository->add($id,$request);
        return Redirect::to('/tarefas');
    }

    public function delete($id){
        $tarefa =  $this->repository->add($id);
        return Redirect::to('/tarefas');
    }
}
