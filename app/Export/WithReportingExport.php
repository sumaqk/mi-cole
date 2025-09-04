<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WithReportingExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    private array $rows;
    private string $title;

    public function __construct(array $rows, string $title)
    {
        $this->rows  = $rows;
        $this->title = $title;
    }

    public function headings(): array
    {
        return [
            ["Instituciones con reporte — {$this->title}"],
            ['UGEL','Institución','Prestador','Provincia','Distrito','Periodo año','Periodo mes','MCR S.1','MCR S.2','MCR S.3','MCR S.4','MCR S.5','Promedio','Estado'],
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22, 'B' => 36, 'C' => 18, 'D' => 16, 'E' => 16,
            'F' => 12, 'G' => 14, 'H' => 10, 'I' => 10, 'J' => 10,
            'K' => 10, 'L' => 10, 'M' => 12, 'N' => 16,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2:N2')->getFont()->setBold(true);
        return [];
    }
}