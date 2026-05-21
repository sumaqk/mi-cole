<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class InstitutionSheetExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles, WithTitle
{
    private array  $rows;
    private string $sheetTitle;
    private string $headerColor;
    private int    $total;

    // headerColor en hex sin #
    public function __construct(array $rows, string $sheetTitle, string $headerColor = '1570ef')
    {
        $this->rows        = $rows;
        $this->sheetTitle  = $sheetTitle;
        $this->headerColor = $headerColor;
        $this->total       = count($rows);
    }

    public function title(): string
    {
        return $this->sheetTitle;
    }

    public function headings(): array
    {
        return [
            ["{$this->sheetTitle} — {$this->total} institución(es) — Exportado: " . now()->format('d/m/Y H:i')],
            ['N°', 'Institución', 'Prestador', 'Distrito', 'Provincia', 'UGEL', 'Latitud', 'Longitud', 'En mapa', 'Usuario', 'Registros', 'Estado'],
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 38,
            'C' => 28,
            'D' => 20,
            'E' => 18,
            'F' => 22,
            'G' => 14,
            'H' => 14,
            'I' => 10,
            'J' => 12,
            'K' => 12,
            'L' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->total + 2;
        $lastCol = 'L';

        // Fila título — merge + estilo grande
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $this->headerColor]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Fila cabecera de columnas
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0f2d5c']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '1570ef']]],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        // Filas de datos — alternadas
        for ($row = 3; $row <= $lastRow; $row++) {
            $bg = ($row % 2 === 0) ? 'eef5ff' : 'ffffff';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_HAIR, 'color' => ['rgb' => 'd0e0f5']]],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(18);
        }

        // Columna N° centrada
        if ($lastRow >= 3) {
            $sheet->getStyle("A3:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Columnas numéricas centradas
        foreach (['G', 'H', 'I', 'J', 'K'] as $col) {
            if ($lastRow >= 3) {
                $sheet->getStyle("{$col}3:{$col}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        // Colores semánticos en columna Estado (L)
        for ($row = 3; $row <= $lastRow; $row++) {
            $estado = $sheet->getCell("L{$row}")->getValue();
            if ($estado === 'Activo') {
                $sheet->getStyle("L{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '15803d']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dcfce7']],
                ]);
            } elseif ($estado === 'Inactivo') {
                $sheet->getStyle("L{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'b91c1c']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'fee2e2']],
                ]);
            }
        }

        // Colores semánticos en columna En mapa (I)
        for ($row = 3; $row <= $lastRow; $row++) {
            $mapa = $sheet->getCell("I{$row}")->getValue();
            if ($mapa === 'Sí') {
                $sheet->getStyle("I{$row}")->getFont()->getColor()->setRGB('15803d');
                $sheet->getStyle("I{$row}")->getFont()->setBold(true);
            } else {
                $sheet->getStyle("I{$row}")->getFont()->getColor()->setRGB('b45309');
                $sheet->getStyle("I{$row}")->getFont()->setBold(true);
            }
        }

        // Borde exterior general
        if ($lastRow >= 2) {
            $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getBorders()->getOutline()->applyFromArray([
                'borderStyle' => Border::BORDER_MEDIUM,
                'color'       => ['rgb' => $this->headerColor],
            ]);
        }

        // Freeze la cabecera
        $sheet->freezePane('A3');

        return [];
    }
}
