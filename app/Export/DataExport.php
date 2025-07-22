<?php
namespace App\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromArray, WithStyles, WithColumnWidths
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

    // Estilos para las celdas
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Negrita en la primera fila
        ];
    }

    // Ajustar el ancho de las columnas
    public function columnWidths(): array
    {
        return [
            'A' => 25, // Ajusta según el contenido esperado
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 20,
            'M' => 15,
        ];
    }
	
}
?>