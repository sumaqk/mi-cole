<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Hoja con todas las instituciones (con y sin reporte) de un mes,
 * con el mismo formato que la tabla del dashboard.
 *
 * Cada fila: ['ugel','nombre','prestador','provincia','distrito','mes','weeks' => [5 x float|null],'estado' => float|null]
 */
class GeneralReportSheet implements FromArray, WithEvents, WithTitle
{
    private const NAVY   = '1E3A5F';
    private const STRIPE = 'F4F8FC';
    private const BORDER = 'D6E2EE';

    public function __construct(
        private array $rows,
        private string $sheetTitle,
        private string $heading,
        private ?int $refWeek,
    ) {}

    public function title(): string
    {
        return $this->sheetTitle;
    }

    public function array(): array
    {
        return [];
    }

    public static function status(?float $v): array
    {
        if ($v === null) return ['SIN REPORTE', '64748B', 'EEF2F6'];
        if ($v < 0.3)    return ['CRÍTICO',     'DC2626', 'FDE8E8'];
        if ($v < 0.5)    return ['DEFICIENTE',  'EA580C', 'FFEEDD'];
        if ($v <= 2.0)   return ['ÓPTIMO',      '16A34A', 'E3F7EA'];
        if ($v <= 5.0)   return ['ALTO',        '2563EB', 'E3ECFD'];
        return                  ['EXCESIVO',    '9333EA', 'F3E8FD'];
    }

    public function registerEvents(): array
    {
        return [AfterSheet::class => function (AfterSheet $event) {
            $sh = $event->sheet->getDelegate();
            $last = 'L';

            $total   = count($this->rows);
            $withRep = count(array_filter($this->rows, fn($r) => count(array_filter($r['weeks'], fn($v) => $v !== null)) > 0));

            $sh->setCellValue('A1', $this->heading);
            $sh->mergeCells("A1:{$last}1");
            $sh->getStyle("A1:{$last}1")->applyFromArray([
                'font'      => ['bold' => true, 'size' => 15, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::NAVY]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
            ]);
            $sh->getRowDimension(1)->setRowHeight(30);

            $sub = 'Generado el ' . date('d/m/Y H:i')
                . ($this->refWeek ? " · Estado actual según semana {$this->refWeek}" : ' · Estado actual según último reporte del mes')
                . " · Total: {$total} · Con reporte: {$withRep} · Sin reporte: " . ($total - $withRep);
            $sh->setCellValue('A2', $sub);
            $sh->mergeCells("A2:{$last}2");
            $sh->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->getColor()->setRGB('475569');

            // Leyenda de colores
            $legend = [[null, 'Sin reporte'], [0.1, '< 0.3 Crítico'], [0.4, '0.3–0.5 Deficiente'], [1.0, '0.5–2 Óptimo'], [3.0, '2–5 Alto'], [6.0, '> 5 Excesivo']];
            $col = 'A';
            foreach ($legend as [$v, $txt]) {
                [, $fg, $bg] = self::status($v);
                $sh->setCellValue("{$col}3", $txt);
                $sh->getStyle("{$col}3")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => $fg]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $col++;
            }

            $hr = 5;
            $headers = ['UGEL', 'Institución', 'Prestador', 'Provincia', 'Distrito', 'Mes', 'MCR 1', 'MCR 2', 'MCR 3', 'MCR 4', 'MCR 5', 'Estado actual'];
            $sh->fromArray($headers, null, "A{$hr}");
            $sh->getStyle("A{$hr}:{$last}{$hr}")->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::NAVY]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sh->getStyle("G{$hr}:K{$hr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sh->getRowDimension($hr)->setRowHeight(22);

            $r = $hr + 1;
            foreach ($this->rows as $i => $row) {
                $sh->fromArray([$row['ugel'], $row['nombre'], $row['prestador'], $row['provincia'], $row['distrito'], mb_substr($row['mes'], 0, 3)], null, "A{$r}");
                if ($i % 2 === 1) {
                    $sh->getStyle("A{$r}:{$last}{$r}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::STRIPE);
                }
                $sh->getStyle("B{$r}")->getFont()->setBold(true)->getColor()->setRGB('0F172A');
                $sh->getStyle("A{$r}")->getFont()->getColor()->setRGB('334155');
                $sh->getStyle("C{$r}:F{$r}")->getFont()->getColor()->setRGB('334155');

                foreach ($row['weeks'] as $w => $v) {
                    $cell = chr(ord('G') + $w) . $r;
                    $style = $sh->getStyle($cell);
                    if ($v === null) {
                        $sh->setCellValue($cell, '—');
                        $style->getFont()->getColor()->setRGB('94A3B8');
                    } else {
                        [, $fg] = self::status($v);
                        $sh->setCellValue($cell, $v);
                        $style->getNumberFormat()->setFormatCode('0.0');
                        $style->getFont()->setBold(true)->getColor()->setRGB($fg);
                    }
                    if ($this->refWeek === $w + 1) {
                        [, , $bg] = self::status($v);
                        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bg);
                        $style->getFont()->setBold(true);
                    }
                }

                [$label, $fg, $bg] = self::status($row['estado']);
                $sh->setCellValue("L{$r}", $row['estado'] === null ? $label : number_format($row['estado'], 1, '.', '') . " — {$label}");
                $sh->getStyle("L{$r}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => $fg]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                ]);
                $r++;
            }
            $lastRow = max($hr, $r - 1);

            $sh->getStyle("G{$hr}:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sh->getStyle("A{$hr}:{$last}{$lastRow}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB(self::BORDER);
            $sh->getStyle("A" . ($hr + 1) . ":{$last}{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Resumen por estado al pie
            $counts = [];
            foreach ($this->rows as $row) {
                $counts[self::status($row['estado'])[0]] = ($counts[self::status($row['estado'])[0]] ?? 0) + 1;
            }
            $sr = $lastRow + 2;
            $sh->setCellValue("A{$sr}", 'Resumen por estado actual');
            $sh->getStyle("A{$sr}")->getFont()->setBold(true)->getColor()->setRGB(self::NAVY);
            foreach ([null, 0.1, 0.4, 1.0, 3.0, 6.0] as $v) {
                $sr++;
                [$label, $fg, $bg] = self::status($v);
                $sh->setCellValue("A{$sr}", $label);
                $sh->setCellValue("B{$sr}", $counts[$label] ?? 0);
                $sh->getStyle("A{$sr}:B{$sr}")->applyFromArray([
                    'font'    => ['bold' => true, 'color' => ['rgb' => $fg]],
                    'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => self::BORDER]]],
                ]);
                $sh->getStyle("B{$sr}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }

            foreach (['A' => 18, 'B' => 38, 'C' => 18, 'D' => 16, 'E' => 18, 'F' => 8, 'G' => 9, 'H' => 9, 'I' => 9, 'J' => 9, 'K' => 9, 'L' => 22] as $c => $wd) {
                $sh->getColumnDimension($c)->setWidth($wd);
            }
            $sh->setAutoFilter("A{$hr}:{$last}{$lastRow}");
            $sh->freezePane('C' . ($hr + 1));
            $sh->setShowGridlines(false);
        }];
    }
}
