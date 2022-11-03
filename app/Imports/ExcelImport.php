<?php

namespace App\Imports;

use App\Models\Cadry;
use App\Models\CadryRelative;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;


class ExcelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');

    }
}
