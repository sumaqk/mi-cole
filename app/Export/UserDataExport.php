<?php
namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UserDataExport implements FromArray, WithStyles, WithColumnWidths
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
                'startColor' => ['rgb' => '28A745'],
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
                $statusValue = $sheet->getCell('E' . $i)->getValue();
                if ($statusValue === 'Activo') {
                    $sheet->getStyle('E' . $i)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => '28A745'],
                            'bold' => true,
                        ],
                    ]);
                } elseif ($statusValue === 'Pendiente') {
                    $sheet->getStyle('E' . $i)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => 'FFC107'],
                            'bold' => true,
                        ],
                    ]);
                } elseif ($statusValue === 'Bloqueado') {
                    $sheet->getStyle('E' . $i)->applyFromArray([
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
            'B' => 30, // EMAIL
            'C' => 25, // NOMBRE COMPLETO
            'D' => 20, // ROL
            'E' => 12, // ESTADO
            'F' => 35, // INSTITUCIÓN
            'G' => 15, // ÚLTIMO ACCESO
            'H' => 18, // FECHA REGISTRO
        ];
    }
}