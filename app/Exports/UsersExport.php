<?php

namespace App\Exports;

use App\Models\UserOrganization;
use App\Models\Cadry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cadry::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
    }
}
