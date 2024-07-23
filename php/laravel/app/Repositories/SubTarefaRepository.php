<?php

namespace App\Repositories;

use App\Models\Tarefas;
use App\Models\SubTarefa;
use App\Repositories\InvokeLambdaRepository;

class SubTarefaRepository
{

	protected $invokeLambdaRepository;

    public function __construct(InvokeLambdaRepository $invokeLambdaRepository)
    {
        $this->invokeLambdaRepository = $invokeLambdaRepository;
    }

	public function getAll()
	{
		return SubTarefa::all();
	}

	public function find($id)
	{
		return SubTarefa::findOrFail($id);
	}

	public function concluir($id)
	{
		
		$subtarefa               = Subtarefa::findOrFail($id);
		$subtarefa->is_completed = true;
		$subtarefa->save();

		$payload = ['message' => 'contabilizar'];
        $response = $this->invokeLambdaRepository->invokeLambdaFunction($payload);

		// Verificar se todas as subtarefas da tarefa estão concluídas
		$tarefa                 = $subtarefa->tarefa;
		$allSubtarefasCompleted = $tarefa->subtarefas()->where('is_completed', false)->count() == 0;

		if ($allSubtarefasCompleted) {
			$tarefa->is_completed = true;
			$tarefa->save();
		}
	}

	public function create(array $data, $tarefa_id)
	{
		$tarefa             = Tarefas::findOrFail($tarefa_id);
		$subtarefa          = new Subtarefa($data);
		$subtarefa->task_id = $tarefa->id;
		$subtarefa->save();

		return $subtarefa;
	}

	public function update($id, array $data)
	{
		$subtarefa = $this->find($id);
		$subtarefa->update($data);
		return $subtarefa;
	}

	public function delete($id)
	{
		$subtarefa = $this->find($id);
		return $subtarefa->delete();
	}
}
