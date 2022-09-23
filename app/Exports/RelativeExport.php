<?php

namespace App\Exports;

use App\Models\Relative;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\CadryExportResource;

class RelativeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $all;

    function __construct($all) {
            $this->all = $all;
    }

    public function collection()
    {
       // dd($this->all);
        return CadryExportResource::collection($this->all);
    }
}
