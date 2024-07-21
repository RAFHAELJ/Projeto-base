<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use Illuminate\Http\Request;
use App\Http\Requests\SubTarefasRequest;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\SubTarefaRepository;

class SubTarefasController extends Controller
{
	protected $subtarefasRepository;

	public function __construct(SubTarefaRepository $subtarefasRepository)
	{
		$this->subtarefasRepository = $subtarefasRepository;
	}

	public function index()
	{
		$subtarefas = $this->subtarefasRepository->getAll();
		return view('subtarefas.list', compact('subtarefas'));
	}

	public function new($tarefa_id)
	{
		$tarefa = Tarefas::findOrFail($tarefa_id);
		return view('subTarefas.form', compact('tarefa'));
	}

	public function concluir($id)
	{
		$subtarefas = $this->subtarefasRepository->concluir($id);
		return redirect()->back()->with('status', 'Subtarefa marcada como concluída!');
	}

	public function store(SubTarefasRequest $request, $tarefa_id)
	{
		$data = $request->validated();
		$this->subtarefasRepository->create($data, $tarefa_id);
		return redirect()->to('/tarefas/' . $tarefa_id)->with('status', 'Subtarefa atualizada com sucesso!');
	}

	public function edit($id)
	{
		$subtask = $this->subtarefasRepository->find($id);
		return view('subtarefas.form', compact('subtask'));
	}

	public function update(SubTarefasRequest $request, $id)
	{
		$subtarefa =$this->subtarefasRepository->update($id, $request->validated());
		return redirect()->back()->with('subtarefaUpdated', $id);
	}

	public function destroy($id)
	{
		$this->subtarefasRepository->delete($id);
		return redirect()->back()->with('subtarefaDeleted', $id);
	}
}
