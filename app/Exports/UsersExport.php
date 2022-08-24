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
        ->where('organization_id', auth()->user()->userorganization->organization_id )
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

        foreach($cadries as $item)
        {
            $lang = Language::whereIn('id', explode(',', $item->language))->pluck('name')->toArray();
            $x ++; 
            $arr[$x]['familiya'] = $item->last_name;
            $arr[$x]['ism'] = $item->first_name;
            $arr[$x]['sharifi'] = $item->middle_name;

            $arr[$x]['birth_region'] = $item->birth_region->name;
            $arr[$x]['birth_city'] = $item->birth_city->name;
            $arr[$x]['birht_date'] = $item->birht_date;
            $arr[$x]['address_region'] = $item->address_region->name;
            $arr[$x]['address_city'] = $item->address_city->name;
            $arr[$x]['address'] = $item->address;

            $arr[$x]['category'] = $item->allStaffs[0]->staff->category->name;

            $arr[$x]['pass_region'] = $item->pass_region->name;
            $arr[$x]['pass_city'] = $item->pass_city->name ?? '';
            $arr[$x]['passport'] = $item->passport;
            $arr[$x]['pass_date'] = $item->pass_date;
            $arr[$x]['jshshir'] = $item->jshshir;

            $arr[$x]['education'] = $item->education->name;
            $arr[$x]['nationality'] = $item->nationality->name;
            $arr[$x]['party'] = $item->party->name;
            $arr[$x]['cadry_title'] = $item->cadry_title->name;
            $arr[$x]['cadry_degree'] = $item->cadry_degree->name;
            $arr[$x]['military_rank'] = $item->military_rank;
            $arr[$x]['deputy'] = $item->deputy;
            $arr[$x]['language'] =  implode(',',$lang);
            $arr[$x]['phone'] = $item->phone;

            if($item->sex == true) 
                $arr[$x]['sex'] = "Erkak"; 
            else 
                $arr[$x]['sex'] = "Ayol";

            $arr[$x]['job_date'] = $item->job_date;
            
            $arr[$x]['department'] = $item->allStaffs[0]->department->name;
            $arr[$x]['staff_date'] = $item->allStaffs[0]->staff_date;
            $arr[$x]['staff_name'] = $item->allStaffs[0]->staff_full;

        }
       // dd($arr);
       return view('export.export_cadry', [
            'cadries' => $cadries
        ]);
    }
}
