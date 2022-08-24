<?php

namespace App\Exports;

use App\Models\UserOrganization;
use App\Models\Cadry;
use App\Models\Language;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $all;

    function __construct($all) {
            $this->all = $all;
    }

    public function view(): View
    {
        $name_se = $this->all['name_se'];
        $staff_se = $this->all['staff_se'];
        $education_se = $this->all['education_se'];
        $region_se = $this->all['region_se'];
        $dep_id = $this->all['dep_id'];
        $sex_se = $this->all['sex_se'];
        $start_se = $this->all['start_se'];
        $end_se = $this->all['end_se'];

        $cadries = Cadry::query()
        ->where('status',true)
        ->where('organization_id', auth()->user()->userorganization->organization_id)
        ->when(\Request::input('name_se'),function($query, $name_se){
            $query->where(function ($query) use ($name_se) {
                $query->orWhere('last_name', 'LIKE', '%'. $name_se .'%')
                    ->orWhere('first_name', 'LIKE', '%'.$name_se.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$name_se.'%');
               
            });
        })->when(request('staff_se'), function ($query, $staff_se) {
            return $query->where('staff_id', $staff_se);

        })->when(request('education_se'), function ($query, $education_se) {
            return $query->where('education_id', $education_se);

        })->when(request('region_se'), function ($query, $region_se) {
            return $query->where('birth_region_id', $region_se);

        })->when(request('dep_id'), function ($query, $dep_id) {
            return $query->where('department_id', $dep_id);

        })->when(request('sex_se'), function ($query, $sex_se) {
            if($sex_se == "true") $z = true; else $z = false;
            return $query->where('sex', $z);

        })->when(request('start_se'), function ($query, $start_se) {
            return $query->whereYear('birht_date', '<=', now()->format('Y') - $start_se);

        })->when(request('end_se'), function ($query, $end_se) {
            return $query->whereYear('birht_date', '>=', now()->format('Y') - $end_se);

        })->with(['education','birth_city','birth_region','staff','pass_region','pass_city','address_region','address_city','nationality','education','party',
        'cadry_title','cadry_degree','allStaffs','allStaffs.department','allStaffs.staff.category'])->get();

        $arr = []; $x = 0;

       return view('export.export_cadry', [
            'cadries' => $cadries
        ]);
    }
}
