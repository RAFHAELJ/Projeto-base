<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'description',
		'deadline_until',
		'sector',
	];

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
