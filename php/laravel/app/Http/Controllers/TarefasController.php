<?php

namespace App\Http\Controllers;

use Redirect;
use App\Models\Tarefa;
use App\Models\Projeto;
use Illuminate\Http\Request;
use App\Repositories\TarefasRepository;

class TarefasController extends Controller
{
	public function __construct(TarefasRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		$tarefas =  $this->repository->index();

		return \view('tarefas.list', ['tarefas'=>$tarefas]);
	}

	public function new()
	{
		$projetos = Projeto::all();
		return view('tarefas.form', compact('projetos'));
	}

	public function show($id)
	{
		$tarefa     = $this->repository->find($id);
		$subtarefas = $tarefa->subtarefas;

		return view('tarefas.show', compact('tarefa', 'subtarefas'));
	}

	public function store(Request $request)
	{
		$tarefa =  $this->repository->create($request);
		return Redirect::to('/tarefas');
	}

	public function edit($id)
	{
		$tarefa =  $this->repository->edit($id);
		return view('tarefas.form', ['tarefa'=>$tarefa]);
	}

	public function update($id, Request $request)
	{
		$tarefa =  $this->repository->add($id, $request);
		return Redirect::to('/tarefas');
	}

	public function destroy($id)
	{
		$tarefa =  $this->repository->delete($id);
		return Redirect::to('/tarefas');
	}

	public function generateTemplate()
	{
		$tarefa =  $this->repository->generateTemplate();

		return $tarefa;
	}

	public function upload(Request $request)
	{
		$tarefas = $this->repository->upload($request);

		return redirect()->back()->with('status', 'Tarefas importadas com sucesso!');
	}
}
