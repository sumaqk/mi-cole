<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NonReportingExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
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
            ["Instituciones sin reporte — {$this->title}"],
            ['UGEL','Institución','Prestador','Provincia','Distrito','Periodo año','Periodo mes','Semana','Observación'],
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
            'F' => 12, 'G' => 14, 'H' => 10, 'I' => 32,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2:I2')->getFont()->setBold(true);
        return [];
    }
}
