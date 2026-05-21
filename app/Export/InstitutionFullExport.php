<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InstitutionFullExport implements WithMultipleSheets
{
    private array $sheets;

    public function __construct(array $sheets)
    {
        $this->sheets = $sheets;
    }

    public function sheets(): array
    {
        return $this->sheets;
    }
}
