<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HistoricoConversa extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'historico_conversa';

    protected $fillable = [
        'user_id', 'destination_id', 'message'
    ];
}
