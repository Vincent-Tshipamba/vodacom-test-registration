<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CodesImport implements ToCollection
{
    /**
     * Convertir les données Excel en collection.
     * 
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
