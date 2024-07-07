<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_completed',
        'opened_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'opened_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the task.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
