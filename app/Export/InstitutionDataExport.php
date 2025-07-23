<?php
namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class InstitutionDataExport implements FromArray, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $lastRow = count($this->data);
        if ($lastRow > 1) {
            $sheet->getStyle('A2:H' . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            for ($i = 2; $i <= $lastRow; $i++) {
                if ($i % 2 == 0) {
                    $sheet->getStyle('A' . $i . ':H' . $i)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8F9FA'], 
                        ],
                    ]);
                }
            }

            for ($i = 2; $i <= $lastRow; $i++) {
                $statusValue = $sheet->getCell('G' . $i)->getValue();
                if ($statusValue === 'Activo') {
                    $sheet->getStyle('G' . $i)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => '28A745'], 
                            'bold' => true,
                        ],
                    ]);
                } elseif ($statusValue === 'Inactivo') {
                    $sheet->getStyle('G' . $i)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => 'DC3545'], 
                            'bold' => true,
                        ],
                    ]);
                }
            }
        }

        $sheet->getRowDimension('1')->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // ID
            'B' => 25, // UGEL
            'C' => 35, // INSTITUCIÓN
            'D' => 20, // PRESTADOR
            'E' => 20, // PROVINCIA
            'F' => 20, // DISTRITO
            'G' => 12, // ESTADO
            'H' => 18, // FECHA CREACIÓN
        ];
    }
}