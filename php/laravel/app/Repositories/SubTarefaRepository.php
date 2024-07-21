<?php

namespace App\Repositories;

use App\Models\Tarefas;
use App\Models\SubTarefa;

class SubTarefaRepository
{
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
