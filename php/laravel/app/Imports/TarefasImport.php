<?php

namespace App\Imports;


use auth;
use App\Models\Tarefas;
use App\Models\SubTarefa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TarefasImport implements ToCollection
{
    protected $userId;

    public function __construct($userId)
    {
        
        $this->userId = $userId;
    }
    public function collection(Collection $rows)
    {
        $header = $rows->first(); // O cabeçalho está na primeira linha
        $rows->shift(); // Remove o cabeçalho do restante dos dados

        $tarefas = [];

        foreach ($rows as $row) {
            $row = array_combine($header->toArray(), $row->toArray());

            // Verificar se a tarefa já foi criada
            if (!isset($tarefas[$row['ID do Projeto']])) {
                $tarefa = Tarefas::create([
                    'project_id' => $row['ID do Projeto'],
                    'title' => $row['Título da Tarefa'],
                    'description' => $row['Descrição da Tarefa'],
                    'days' => $row['Dias'],
                    'user_id' => $this->userId,
                ]);

                $tarefas[$row['ID do Projeto']] = $tarefa;
            } else {
                $tarefa = $tarefas[$row['ID do Projeto']];
            }

            // Adicionar subtarefas
            if (!empty($row['ID da Subtarefa'])) {
                SubTarefa::create([
                    'task_id' => $tarefa->id,
                    'title' => $row['Título da Subtarefa'],
                    'description' => $row['Descrição da Subtarefa'],
                ]);
            }
        }
    }
}
