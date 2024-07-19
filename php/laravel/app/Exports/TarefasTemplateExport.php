<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TarefasTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'ID do Projeto',
            'Título da Tarefa',
            'Descrição da Tarefa',
            'Dias',
            'Concluída?',
            'ID da Subtarefa',
            'Título da Subtarefa',
            'Descrição da Subtarefa',
            'Concluída?'
        ];
    }

    public function array(): array
    {
        // Dados de exemplo com múltiplas subtarefas para cada tarefa
        return [
            [1, 'Exemplo Tarefa 1', 'Descrição da Tarefa 1', 5, 'Não', 1, 'Exemplo SubTarefa 1', 'Descrição da SubTarefa 1', 'Não'],
            [1, 'Exemplo Tarefa 1', 'Descrição da Tarefa 1', 5, 'Não', 2, 'Exemplo SubTarefa 2', 'Descrição da SubTarefa 2', 'Sim'],
            [2, 'Exemplo Tarefa 2', 'Descrição da Tarefa 2', 10, 'Sim', 3, 'Exemplo SubTarefa 3', 'Descrição da SubTarefa 3', 'Não'],
            [2, 'Exemplo Tarefa 2', 'Descrição da Tarefa 2', 10, 'Sim', 4, 'Exemplo SubTarefa 4', 'Descrição da SubTarefa 4', 'Sim'],
            [2, 'Exemplo Tarefa 2', 'Descrição da Tarefa 2', 10, 'Sim', 5, 'Exemplo SubTarefa 5', 'Descrição da SubTarefa 5', 'Sim'],
            // Adicione mais linhas conforme necessário
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Texto branco
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0000FF'], // Fundo azul
            ],
        ];

        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Formatação das colunas
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(15);
    }
}
