<?php


namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class WaterDetailedExport implements FromArray, WithStyles, WithColumnWidths
{
    protected $data;
    protected $mesesTrimestre;

    public function __construct(array $data, array $mesesTrimestre)
    {
        $this->data = $data;
        $this->mesesTrimestre = $mesesTrimestre;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        $totalColumns = count($this->data[0]);
        $lastColumn = chr(64 + $totalColumns);
        $lastRow = count($this->data);

        $this->crearEncabezadosAgrupados($sheet, $totalColumns);
        
        $sheet->getStyle('A1:F2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4E79'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');

        $sheet->setCellValue('A1', 'N°');
        $sheet->setCellValue('B1', 'UGEL');
        $sheet->setCellValue('C1', 'Institución');
        $sheet->setCellValue('D1', 'Prestador');
        $sheet->setCellValue('E1', 'Provincia');
        $sheet->setCellValue('F1', 'Distrito');
        if ($lastRow > 2) {
            $sheet->getStyle("A3:{$lastColumn}{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ],
            ]);
            for ($i = 3; $i <= $lastRow; $i++) {
                if ($i % 2 == 1) {
                    $sheet->getStyle("A{$i}:{$lastColumn}{$i}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8F9FA'],
                        ],
                    ]);
                }
            }
            $this->colorearValoresMCR($sheet, $lastRow, $totalColumns);
            $this->colorearObservacionesYSituacion($sheet, $lastRow, $totalColumns);
        }

        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getRowDimension('2')->setRowHeight(25);

        for ($i = 3; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(40);
        }

        return [];
    }

    private function crearEncabezadosAgrupados($sheet, $totalColumns)
    {
        $colInicio = 7;
        
        foreach ($this->mesesTrimestre as $mes) {
            $colInicioLetra = chr(64 + $colInicio);
            $colFinLetra = chr(64 + $colInicio + 4); 
            
            $sheet->mergeCells("{$colInicioLetra}1:{$colFinLetra}1");
            $sheet->setCellValue("{$colInicioLetra}1", $mes);

            $sheet->getStyle("{$colInicioLetra}1:{$colFinLetra}1")->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E5984'],
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

            for ($semana = 1; $semana <= 5; $semana++) {
                $colSemanaLetra = chr(64 + $colInicio + $semana - 1);
                $sheet->setCellValue("{$colSemanaLetra}2", "S.$semana");

                $sheet->getStyle("{$colSemanaLetra}2")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 10,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1F4E79'],
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
            }
            
            $colInicio += 5;
        }
        
        $colObservaciones = chr(64 + $totalColumns - 1);
        $colSituacion = chr(64 + $totalColumns);

        $sheet->mergeCells("{$colObservaciones}1:{$colObservaciones}2");
        $sheet->setCellValue("{$colObservaciones}1", "Observaciones");
        
        $sheet->mergeCells("{$colSituacion}1:{$colSituacion}2");
        $sheet->setCellValue("{$colSituacion}1", "Situación Final");
        
        $sheet->getStyle("{$colObservaciones}1:{$colSituacion}2")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4E79'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
    }

    private function colorearValoresMCR($sheet, $lastRow, $totalColumns)
    {
        $inicioMCR = 7;
        $finMCR = $totalColumns - 2;

        for ($row = 3; $row <= $lastRow; $row++) { 
            for ($col = $inicioMCR; $col <= $finMCR; $col++) {
                $colLetter = chr(64 + $col);
                $valor = $sheet->getCell("{$colLetter}{$row}")->getValue();
                
                if ($valor !== '-' && is_numeric($valor)) {
                    $valorNum = floatval($valor);
                    
                    if ($valorNum < 0.5 || $valorNum > 1.0) {
                        $sheet->getStyle("{$colLetter}{$row}")->applyFromArray([
                            'font' => ['color' => ['rgb' => 'DC3545'], 'bold' => true],
                        ]);
                    } else {
                        $sheet->getStyle("{$colLetter}{$row}")->applyFromArray([
                            'font' => ['color' => ['rgb' => '28A745'], 'bold' => true],
                        ]);
                    }
                }
            }
        }
    }

    private function colorearObservacionesYSituacion($sheet, $lastRow, $totalColumns)
    {
        $colObservaciones = chr(64 + $totalColumns - 1);
        $colSituacion = chr(64 + $totalColumns);

        for ($row = 3; $row <= $lastRow; $row++) { 
            $observacion = $sheet->getCell("{$colObservaciones}{$row}")->getValue();
            
            $colorObservacion = '6C757D';
            if (strpos($observacion, 'Reportó todas') !== false) {
                $colorObservacion = '28A745';
            } elseif (strpos($observacion, 'Nunca subió') !== false) {
                $colorObservacion = 'DC3545';
            } elseif (strpos($observacion, 'Muy pocas') !== false) {
                $colorObservacion = 'A52A2A';
            } elseif (strpos($observacion, 'Pocas semanas') !== false) {
                $colorObservacion = 'FFC107';
            } elseif (strpos($observacion, 'Algunas semanas') !== false) {
                $colorObservacion = 'FF8C00';
            } elseif (strpos($observacion, 'Varias semanas') !== false) {
                $colorObservacion = 'FFB347';
            }
            
            $sheet->getStyle("{$colObservaciones}{$row}")->applyFromArray([
                'font' => ['color' => ['rgb' => $colorObservacion], 'bold' => true],
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ]);

            $situacion = $sheet->getCell("{$colSituacion}{$row}")->getValue();
            
            $colorSituacion = '6C757D';
            if (strpos($situacion, 'avances positivos') !== false) {
                $colorSituacion = '28A745';
            } elseif (strpos($situacion, 'inadecuado') !== false) {
                $colorSituacion = 'DC3545';
            } elseif (strpos($situacion, 'Sin reportes') !== false) {
                $colorSituacion = 'A52A2A';
            } elseif (strpos($situacion, 'No se conoce') !== false) {
                $colorSituacion = '6C757D';
            } elseif (strpos($situacion, 'inconsistencias') !== false) {
                $colorSituacion = 'FF4500';
            }
            
            $sheet->getStyle("{$colSituacion}{$row}")->applyFromArray([
                'font' => ['color' => ['rgb' => $colorSituacion], 'bold' => true],
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ]);
        }
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 5,  // N°
            'B' => 20, // UGEL
            'C' => 35, // Institución (más ancho para word wrap)
            'D' => 18, // Prestador
            'E' => 15, // Provincia
            'F' => 15, // Distrito
        ];

        for ($i = 7; $i <= 21; $i++) {
            $letter = chr(64 + $i);
            $widths[$letter] = 8;
        }

        $widths['V'] = 30;
        $widths['W'] = 40;

        return $widths;
    }
}