<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTarefa extends Model
{
	use HasFactory;

	protected $table = 'subtarefas';

	protected $fillable = [
		'task_id',
		'title',
		'description',
		'is_completed',
	];

	/**
	 * Get the task that owns the subtask.
	 */
	public function tarefa()
	{
		return $this->belongsTo(Tarefas::class, 'task_id');
	}
}
