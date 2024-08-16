<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyScheduledTask extends Command
{
    protected $signature = 'task:run';
    protected $description = 'Descrição da minha tarefa agendada';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lógica da tarefa agendada aqui
        \Log::info('Tarefa agendada executada com sucesso!');
    }
}
