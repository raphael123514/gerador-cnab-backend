<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CnabImport implements ToCollection, WithHeadingRow
{
    public Collection $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }
}
