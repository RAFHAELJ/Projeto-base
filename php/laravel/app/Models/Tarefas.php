<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'sector_id',
        'title',
        'days',
        'description',
        'is_completed',
        'opened_at',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'opened_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    
    public function subtarefas()
{
    return $this->hasMany(SubTarefa::class, 'task_id');
}
}
