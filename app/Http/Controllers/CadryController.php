<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Railway;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Exports\UsersExport;
use App\Models\Cadry;
use App\Models\UserOrganization;
use App\Models\Department;
use App\Models\Region;
use App\Models\City;
use App\Models\Education;
use App\Models\AcademicTitle;
use App\Models\AcademicDegree;
use App\Models\Nationality;
use App\Models\Language;
use App\Models\Party;
use App\Models\WorkLevel;
use App\Models\Staff;
use App\Models\Relative;
use App\Models\InfoEducation;
use App\Models\Career;
use App\Models\CadryRelative;
use App\Models\Category;
use App\Models\Institut;
use App\Models\MedicalExamination;
use App\Models\DisciplinaryAction;
use App\Models\Incentive;
use App\Models\DemoCadry;
use App\Models\User;
use App\Models\AbroadStudy;
use App\Models\AcademiStudy;
use App\Models\Abroad;
use App\Models\AcademicName;
use App\Models\StaffFile;
use App\Models\Vacation;
use App\Models\StavkaDou;
use App\Models\Classification;
use App\Models\DepartmentCadry;
use App\Models\DepartmentStaff;

use App\Http\Resources\RailwayResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\CadryResource;
use App\Http\Resources\CadryCollection;
use App\Http\Resources\OrgResource;
use App\Http\Resources\DepResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\StaffResource;
use Validator;

use Auth;

class CadryController extends Controller
{

    public function index(Request $request)
    {
        //dd($request->all());
        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);
        $cadries = Cadry::FullFilter()->with(['vacation' => function ($query) {
            $query->where('status', true);
        },'allStaffs','department','birth_region','staff'])->paginate(10, ['*'], 'page', $page);
    
        return view('cadry.cadry',[
            'cadries' => $cadries
        ]);
    }
    
    public function decret_cadry($id)
    {
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
       
        $fullcadries = Cadry::where('organization_id', $org_id)->where('status',true)->get();
        $item = Cadry::find($id);

        return view('cadry.decret',[
            'fullcadries' => $fullcadries,
            'item' => $item
        ]);
    }

    public function cadry_department($id)
    {
        $cadries = Cadry::query()
            ->where('status',true)
            ->where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
            ->where('department_id', $id)
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->Orwhere('last_name','like','%'.$search.'%')
                        ->orWhere('first_name','like','%'.$search.'%')
                        ->orWhere('middle_name','like','%'.$search.'%');
                });
            });
        $department_name = Department::find($id)->name;
        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        return view('cadry.cadry_department',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
            'department_name' => $department_name
        ]);
    }

    public function cadry_staff_view($id)
    {
        $cadries = Cadry::query()
            ->where('status',true)
            ->where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
            ->where('staff_id', $id)
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->Orwhere('last_name','like','%'.$search.'%')
                        ->orWhere('first_name','like','%'.$search.'%')
                        ->orWhere('middle_name','like','%'.$search.'%');
                });
            });
        $staff_name = Staff::find($id)->name;
        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        return view('cadry.cadry_staff',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
            'staff_name' => $staff_name
        ]);
    }

    public function staff()
    {
        $staffs = Staff::query()
        ->where('organization_id', Auth::user()->userorganization->organization_id)
        ->when(\Request::input('search'),function($query,$search){
            $query
            ->where('name','like','%'.$search.'%');
        })
        ->with('cadries')->paginate(10);

        $categories = Category::all();

        return view('cadry.staff',[
            'staffs' => $staffs,
            'categories' => $categories,
        ]);
    }

    public function departments()
    {
        $all = 0; $allSv = 0;
        $org_id = Auth::user()->userorganization->organization_id;

        $page = request('page', session('department_page', 1));
        session(['department_page' => $page]);

        if($org_id == 152) {
            $departments = Department::query()->where('id','!=',4304)
            ->where('organization_id', $org_id)
            ->when(\Request::input('search'),function($query,$search){
                $query
                ->where('name','like','%'.$search.'%');
            })->with(['cadries','departmentstaff','departmentcadry'])->paginate(10, ['*'], 'page', $page);
            
            $alldepartments = Department::where('id','!=',4304)->where('organization_id', $org_id)
            ->with(['departmentstaff','departmentstaff.cadry'])->get();
        } else {
            $departments = Department::query()
            ->where('organization_id', $org_id)
            ->when(\Request::input('search'),function($query,$search){
                $query
                ->where('name','like','%'.$search.'%');
            })->with(['cadries','departmentstaff','departmentcadry'])->paginate(10, ['*'], 'page', $page);
            
            $alldepartments = Department::where('organization_id', $org_id)
            ->with(['departmentstaff','departmentstaff.cadry'])->get();
        }
        
        $a = []; $b = []; $plan = []; 
        foreach ($alldepartments as $item)
        {
            $z = 0; $q = 0; $x = 0; $y = 0;$p = 0;
            foreach($item->departmentstaff as $staff) {
                $x = $staff->stavka; $p = $p  + $x;
                $y = $staff->cadry->where('status_decret',false)->sum('stavka');
                if($x>$y) $z = $z + $x - $y;
                if($x<$y) $q = $q + $y - $x;
            }
            
            $a[$item->id] = $z;
            $b[$item->id] = $q;
            $all = $all + $z;
            $allSv =  $allSv + $q;
            $plan[$item->id] = $p;
        }
        

        return view('cadry.departments',[
            'departments' => $departments,
            'a' => $a,
            'b' => $b,
            'all' => $all,
            'allSv' => $allSv,
            'plan' => $plan
        ]);
    }

    public function add_staff(Request $request)
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id);

        $addstaff = new Staff();
        $addstaff->railway_id = $organ->value('railway_id');
        $addstaff->organization_id = $organ->value('organization_id');
        $addstaff->name = $request->name;
        $addstaff->category_id = $request->category_id;
        $addstaff->staff_count = $request->staff_count;
        $addstaff->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_staf(Request $request, $id)
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id);

        $editstaff = Staff::find($id);
        $editstaff->railway_id = $organ->value('railway_id');
        $editstaff->organization_id = $organ->value('organization_id');
        $editstaff->name = $request->name;
        $editstaff->category_id = $request->category_id;
        $editstaff->staff_count = $request->staff_count;
        $editstaff->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function del_staf($id)
    {
        Staff::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function add_department(Request $request)
    {
        $organ = UserOrganization::where('user_id',Auth::user()->id);

        $addDepartment = new Department();
        $addDepartment->railway_id = $organ->value('railway_id');
        $addDepartment->organization_id = $organ->value('organization_id');
        $addDepartment->name = $request->name;
        $addDepartment->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_department(Request $request, $id)
    {
        $editDepartment =  Department::find($id);
        $editDepartment->name = $request->name;
        $editDepartment->save();

        return redirect()->back()->with('msg' ,1);
    }
    public function delete_department($id)
    {
        if (DepartmentCadry::where('department_id', $id)->count()) {
            return response()->json([
                'message' => "error"
            ], 500);
        } else {
            Department::find($id)->delete();
            return response()->json([
                'message' => "Muvaffaqqiyatli o'chirildi!"
            ], 200);
        }

        return redirect()->back()->with('msg' ,1);
    }

    public function regions()
    {
        $regions = Region::all();

        $cities = City::query()->when(\Request::input('search'),function($query,$search){
            $query
            ->where('name','like','%'.$search.'%');
        });


        return view('cadry.regions',[
            'regions' => $regions,
            'cities' => $cities->paginate(10),
        ]);
    }

    public function add_city(Request $request)
    {
       // dd($request->all());
        $cities = new City();
        $cities->region_id = $request->region_id;
        $cities->name = $request->name;
        $cities->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function cadry_search()
    {
        $cadries = Cadry::query()
            ->where('status',true)
            ->where('last_name','like','%'.request('last_name').'%')
            ->where('first_name','like','%'.request('first_name').'%')
            ->where('middle_name','like','%'.request('middle_name').'%')
        ->with('organization')
        ->orderBy('org_order','asc')
        ->orderBy('dep_order','asc');

        $countcadries = $cadries->count();

        return view('uty.search',[
            'cadries' => $cadries->paginate(10),
            'countcadries' => $countcadries
        ]);
    }

    public function cadry_edit($id)
    {
        $cadry = Cadry::with(['allStaffs','allStaffs.depstaff'])->find($id);
        $info = Education::all();
        $academictitle = AcademicTitle::all();
        $academicdegree = AcademicDegree::all();
        $naties = Nationality::all();
        $langues = Language::all();
        $parties = Party::all();
        $worklevel = WorkLevel::all();
        $relatives = Relative::all();

        return view('cadry.edit_cadry',[
            'cadry' => $cadry,
            'info' => $info,
            'academictitle' => $academictitle,
            'academicdegree' => $academicdegree,
            'naties' => $naties,
            'langues' => $langues,
            'parties' => $parties,
            'worklevel' => $worklevel,
        ]);
    }

    public function cadry_leader_view($id)
    {
        $cadry = Cadry::find($id);
        if($cadry->railway_id == UserOrganization::where('user_id',Auth::user()->id)->value('railway_id')) {
            $departments = Department::where('organization_id',$cadry->organization_id)->get();
            $info = Education::all();
            $academictitle = AcademicTitle::all();
            $academicdegree = AcademicDegree::all();
            $naties = Nationality::all();
            $langues = Language::all();
            $parties = Party::all();
            $worklevel = WorkLevel::all();
            $staffs = Staff::where('organization_id', $cadry->organization_id)->get();
            $relatives = Relative::all();
            $regions = Region::all();
            $cities = City::all();
    
            return view('cadry.edit_cadry',[
                'cadry' => $cadry,
                'departments' => $departments,
                'regions' => $regions,
                'cities' => $cities,
                'info' => $info,
                'academictitle' => $academictitle,
                'academicdegree' => $academicdegree,
                'naties' => $naties,
                'langues' => $langues,
                'parties' => $parties,
                'worklevel' => $worklevel,
                'staffs' => $staffs
            ]);
        } else 
        return redirect()->back();
       
    }


    public function cadry_information($id)
    {
        $cadry = Cadry::find($id);
        $railways = Railway::all();
        $info = Education::all();
        $academictitle = AcademicTitle::all();
        $academicdegree = AcademicDegree::all();
        $naties = Nationality::all();
        $langues = Language::all();
        $parties = Party::all();
        $worklevel = WorkLevel::all();
        $academics = AcademiStudy::where('cadry_id', $id)->with('academicname')->get();
        $abroads = AbroadStudy::where('cadry_id',$id)->with('typeabroad')->get();
        $infoeducations = InfoEducation::where('cadry_id',$id)->get();
        $institut = Institut::all();
        $abroadnames = Abroad::all();
        $academicnames = AcademicName::all();

        return view('cadry.cadry_information',[
            'cadry' => $cadry,
            'info' => $info,
            'academictitle' => $academictitle,
            'academicdegree' => $academicdegree,
            'naties' => $naties,
            'langues' => $langues,
            'parties' => $parties,
            'worklevel' => $worklevel,
            'infoeducations' => $infoeducations,
            'institut' => $institut,
            'academics' => $academics,
            'abroads' => $abroads,
            'abroadnames' => $abroadnames,
            'academicnames' => $academicnames
        ]);
    }

    public function add_abroad_cadry($id,Request $request)
    {
        $new = new AbroadStudy();
        $new->cadry_id = $id;
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute;
        $new->direction = $request->direction;
        $new->type_abroad = $request->type_abroad;
        $new->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_abroad_cadry($id)
    {
        $new =  AbroadStudy::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_academic_cadry($id, Request $request)
    {
        $new =  AcademiStudy::find($id);
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute;
        $new->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function add_academic_cadry($id,Request $request)
    {
        $new = new AcademiStudy();
        $new->cadry_id = $id;
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute;
        $new->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_academic_cadry($id)
    {
        $new =  AcademiStudy::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_abroad_cadry($id, Request $request)
    {
        $new =  AbroadStudy::find($id);
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute;
        $new->direction = $request->direction;
        $new->type_abroad = $request->type_abroad;
        $new->save();

        return redirect()->back()->with('msg' ,1);
    }


    public function cadry_career($id)
    {
        $cadry = Cadry::find($id);
     
        $careers = Career::where('cadry_id',$id)
            ->orderBy('sort','asc')->get();

        return view('cadry.cadry_career',[
            'cadry' => $cadry,
            'careers' => $careers
        ]);
    }

    public function cadry_realy($id)
    {
        $cadry = Cadry::find($id);
        $relatives = Relative::all();
        $cadryrelatives = CadryRelative::where('cadry_id',$id)
            ->orderBy('sort','asc')
            ->with('relative')
            ->with('birth_city')
            ->with('address_city')->get();

        return view('cadry.cadry_realy',[
            'cadry' => $cadry,
            'cadryrelatives' => $cadryrelatives,
            'relatives' => $relatives
        ]);
    }
    public function cadry_other($id)
    {
        $cadry = Cadry::find($id);

        $meds = MedicalExamination::where('cadry_id',$id)->get();
        $discips = DisciplinaryAction::where('cadry_id',$id)->get();
        $incentives = Incentive::where('cadry_id',$id)->get();
        $stafffiles = StaffFile::where('cadry_id',$id)->get();

        return view('cadry.cadry-other',[
            'cadry' => $cadry,
            'meds' => $meds,
            'discips' => $discips,
            'incentives' => $incentives,
            'stafffiles' => $stafffiles
        ]);
    }

    public function addworker()
    {
        $railways = Railway::all();
        $departments = Department::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $info = Education::all();
        $academictitle = AcademicTitle::all();
        $academicdegree = AcademicDegree::all();
        $naties = Nationality::all();
        $langues = Language::all();
        $parties = Party::all();
        $worklevel = WorkLevel::all();
        $staffs = Staff::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
        $relatives = Relative::all();
        $regions = Region::all();
        $cities = City::all();

        $institut = Institut::all();

        return view('cadry.addworker',[
            'departments' => $departments,
            'regions' => $regions,
            'cities' => $cities,
            'info' => $info,
            'academictitle' => $academictitle,
            'academicdegree' => $academicdegree,
            'naties' => $naties,
            'langues' => $langues,
            'parties' => $parties,
            'worklevel' => $worklevel,
            'staffs' => $staffs
        ]);
    }

    public function addworkersuccess(Request $request)
    {
        $validator3 = DemoCadry::where('status',true)->where('jshshir',$request->jshshir)->get();

        $validator = Cadry::where('status',true)->where('jshshir',$request->jshshir)->with('organization')->get();
        $validator2 = Cadry::where('status',false)->where('jshshir',$request->jshshir)->with('organization')->get();

        if(count($validator3) > 0)
        {
            return redirect()->back()->with('msg', 6);
        } else
        if ( count($validator) > 0 ) {
            return redirect()->back()->with([
                'msg' => 4, 
                'name' => $validator[0]->organization->name , 
                'cadry_name' => $validator[0]->last_name . ' ' . $validator[0]->first_name . ' ' . $validator[0]->middle_name
            ]);
        } else if(count($validator2) > 0) {
            return redirect()->back()->with('msg', 5);
        } else {

            $dep = DepartmentStaff::with('cadry')->find($request->staff_id);

            $array = $request->all();
            $array['railway_id'] = UserOrganization::where('user_id',Auth::user()->id)->value('railway_id');
            $array['organization_id'] = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
            $array['post_name'] = $dep->staff_full;
            $array['staff_id'] = $dep->staff_id;

            $cadry = Cadry::create($array);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $array['railway_id'];
            $newItem->organization_id = $array['organization_id'];
            $newItem->department_id = $request->department_id;
            $newItem->department_staff_id = $request->staff_id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->post_date;
            //$newItem->staff_status = $request->staff_status;
            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->stavka) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;
                $newItem->cadry_id = $cadry->id;
                $newItem->stavka = $request->stavka;
                $newItem->save();
        
            return redirect()->route('cadry_edit',[$cadry->id])->with('msg',3);
        }

       
    }

    public function edit_cadry_us(Request $request, Cadry $cadry)
    {
        
        $cadry->update($request->all());

        return redirect()->back()->with('msg' ,1);
     

    }

    public function add_discip_cadry(Request $request, $id)
    {
        $dis = new DisciplinaryAction();
        $dis->cadry_id = $id;
        $dis->number = $request->number;
        $dis->date_action = $request->date_action;
        $dis->type_action = $request->type_action;
        $dis->reason_action = $request->reason_action;
        $dis->save();

        return redirect()->back()->with('msg' ,1);
    }
    public function edit_discip_cadry(Request $request, $id)
    {
        $dis = DisciplinaryAction::find($id);
        $dis->number = $request->edit_number;
        $dis->date_action = $request->edit_date_action;
        $dis->type_action = $request->edit_type_action;
        $dis->reason_action = $request->edit_reason_action;
        $dis->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_discip_cadry($id)
    {
        $dis = DisciplinaryAction::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

  
    public function delete_med_cadry($id)
    {
        $med = MedicalExamination::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }
    
    public function add_incentive_cadry(Request $request, $id)
    {
        $incentive = new Incentive();
        $incentive->cadry_id = $id;
        $incentive->by_whom = $request->by_whom;
        $incentive->number = $request->number;
        $incentive->incentive_date = $request->incentive_date;
        $incentive->type_action = $request->type_action;
        $incentive->type_reason = $request->reason_action;
        $incentive->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_incentive_cadry(Request $request, $id)
    {
        $incentive = Incentive::find($id);
        $incentive->by_whom = $request->by_whom;
        $incentive->number = $request->number;
        $incentive->incentive_date = $request->incentive_date;
        $incentive->type_action = $request->type_action;
        $incentive->type_reason = $request->reason_action;
        $incentive->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_incentive_cadry($id)
    {
        $incentive = Incentive::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function add_ins_cadry(Request $request,$id)
    {
        $neweducation = new InfoEducation();
        $neweducation->cadry_id = $id;
        $neweducation->sort = 0;
        $neweducation->date1 = $request->date1;
        $neweducation->date2 = $request->date2;
        $neweducation->institut = $request->institut;
        $neweducation->speciality = $request->speciality;
        $neweducation->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function cadry_info_edit(Request $request,$id)
    {
        $editEducation = InfoEducation::find($id);
        $editEducation->date1 = $request->date1;
        $editEducation->date2 = $request->date2;
        $editEducation->institut = $request->institut;
        $editEducation->speciality = $request->speciality;
        $editEducation->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function cadry_info_delete($id)
    {
        InfoEducation::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_cadry(Request $request,$id)
    {
        $cadry = Cadry::find($id);
        $cadry->status = false;
        $cadry->save();
        
        DepartmentCadry::where('cadry_id',$id)->delete();

        $arr = Cadry::find($id)->toArray();
        $arr['number'] = $request->number ?? '';
        $arr['comment'] = $request->comment ?? '';
        $arr['cadry_id'] = $request->id;

        if($request->blackStatus == 'on') 
            $arr['status'] = true;
            
        DemoCadry::create($arr);

        return redirect()->route('cadry');
    }

    public function add_career_cadry(Request $request,$id)
    {
        $newscareer = new Career();
        $newscareer->cadry_id = $id;
        $newscareer->sort = $request->sort;
        $newscareer->date1 = $request->date1;
        $newscareer->date2 = $request->date2 ?? '';
        $newscareer->staff = $request->staff;
        $newscareer->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function cadry_career_edit(Request $request,$id)
    {
        
        $editcareer = Career::find($id);
        $editcareer->date1 = $request->date1;
        $editcareer->date2 = $request->date2 ?? '';
        $editcareer->staff = $request->staff;
        $editcareer->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function sortable_carer(Request $request)
    {
        $cadry = Career::where('id', $request->order[0]['id'])->value('cadry_id');
        $tasks = Career::where('cadry_id', $cadry)->get();
        foreach ($tasks as $task) {
            $task->timestamps = false; 
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['sort' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);   
    }
    
    public function cadry_career_delete($id)
    {
        Career::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function add_relative_cadry(Request $request,$id)
    {
        $newerelative = new CadryRelative();
        $newerelative->cadry_id = $id;
        $newerelative->relative_id = $request->relative_id;
        $newerelative->sort = $request->sort;
        $newerelative->fullname = $request->fullname;
        $newerelative->birth_place = $request->birth_place;
        $newerelative->post = $request->post;
        $newerelative->address = $request->address ?? '';
        $newerelative->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_relative_cadry(Request $request,$id)
    {
        $editrelative = CadryRelative::find($id);
        $editrelative->relative_id = $request->relative_id;
        $editrelative->fullname = $request->fullname;
        $editrelative->birth_place = $request->birth_place;
        $editrelative->post = $request->post;
        $editrelative->address = $request->address ?? '';
        $editrelative->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function sortable_relatives(Request $request)
    {
        $cadry = CadryRelative::where('id', $request->order[0]['id'])->value('cadry_id');
        $tasks = CadryRelative::where('cadry_id', $cadry)->get();

        foreach ($tasks as $task) {
            $task->timestamps = false; 
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['sort' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);   
    }

    public function delete_relative_cadry($id)
    {
        CadryRelative::find($id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function excelimport()
    {
        return view('cadry.addcadry');
    }
    public function addcadry()
    {
        return view('cadry.addcadry');
    }

    public function organization_index()
    {
        $organizations = Railway::all();
        return view('cadry.organizations',[
            'organizations' => $organizations
        ]);
    }

    public function enterprice_index()
    {
        $organizations = Railway::all();
        $enterprices = Organization::with('railway')->get();
        return view('cadry.enterprice',[
            'enterprices' => $enterprices,
            'organizations' => $organizations
        ]);
    }

    public function base64()
    {

    }


    public function fileImport(Request $request)
    {
        set_time_limit(600);

        $collections = Excel::toCollection(new ExcelImport, $request->file('file'));

        $arr = $collections[0];
        $x = 0;

        foreach($arr as $item)
        {
            $x ++;
            Classification::create([
                'name_ru' => $item[0],
                'name_uz' => $item[1],
                'code_staff' => $item[2],
                'type_staff' => $item[3],
                'category' => $item[4],
            ]);
        }

        dd($x);
    }


    public function back_page_cadry()
    {
        return redirect()->route('cadry');
       //Cadry::where('organization_id',31)->delete();

       set_time_limit(600);
       $organizations = Railway::all();
       $orgs = Cadry::groupBy('railway_id')->select('railway_id')->pluck('railway_id');
       $y = 0;
       $q = [];
       foreach($organizations as $organization){
           $x = 0;
           foreach ($orgs as $org){
               if($organization->id == $org) $x++;
           }
           if($x == 0) {
               $y++;
               $q[$y] = $organization->name;
           }
       }
       dd($q);
    }


    public function statistics(Request $request)
    {
        $railways = Railway::all();
        $organizations = Organization::query()->where('railway_id', request('railway_id', 0))->get();
        $departments = Department::query()->where('organization_id', request('org_id', 0))->get();

            $all = Cadry::filter()->count();
            $man = Cadry::filter()->where('sex',1)->count();
            $woman = $all - $man;
            $dog =  Cadry::filter()->where('worklevel_id',5)->count();

            $decret =  Cadry::filter()->where('status_dec',1)->count();
            $med =  Cadry::filter()->where('status_med',1)->count();
            $bs =  Cadry::filter()->where('status_bs',1)->count();


            $cadry30 = Cadry::filter()->where('birht_date','>=','1992-01-01')->count();
            $cadry45 = Cadry::filter()->where('birht_date','>=','1977-01-01')->count();
            
            $nafaqaMan = Cadry::filter()->where('sex',1)->where('birht_date','<=','1957-01-01')->count();
            $nafaqaWoman = Cadry::filter()->where('sex',0)->where('birht_date','<=','1967-01-01')->count();

            $eduoliy = Cadry::filter()->where('education_id',1)->count();
            $edumaxsus = Cadry::filter()->where('education_id',3)->count();

            $birthdays = Cadry::filter()
                ->whereMonth('birht_date', '=', now()->format('m'))
                ->whereDay('birht_date', '=', now()->format('d'));

            $newcadries = Cadry::filter()->whereDate('created_at',now()->format('Y-m-d'));
       
            $democadries = DemoCadry::filter()->where('status',0)->whereDate('created_at',now()->format('Y-m-d'));
            $democadriesback = DemoCadry::filter()->where('status',1);
            
            $vacations = Vacation::query()
                ->where('status',true)
                ->whereDate( 'date2' , '>=' ,now() )
                ->when(request('railway_id'), function ($query, $railway_id) {
                    return $query->where('railway_id', $railway_id);     
                })->when(request('org_id'), function ($query, $org_id) {
                    return $query->where('organization_id', $org_id);     
                })->when(request('dep_id'), function ($query, $dep_id) {
                    return $query->where('id', $dep_id);     
                });
            $vacDec = $vacations->where('status_decret',true)->count();
            $vac = $vacations->count();

            $allStaffs = DepartmentStaff::Filter();
            $plan = $allStaffs->sum('stavka');
            $sverx = DepartmentStaff::Filter()->whereRaw('stavka < summ_stavka');
            $x = $sverx->sum('stavka');
            $y = $sverx->sum('summ_stavka');
            $sverxCount = $y - $x;

            $vacant = DepartmentStaff::Filter()
                ->where(function ($query) {
                    $query->whereRaw('stavka > summ_stavka')
                            ->orWhere('summ_stavka', null);
                });

            
            $x = $vacant->sum('stavka');
            $y = $vacant->sum('summ_stavka');
            $vacanCount = $x - $y;
            //dd($vacanCount);
         
        return view('uty.statistics', [
            'departments' => $departments,
            'decret' => $decret,
            'nafaqaMan' => $nafaqaMan,
            'nafaqaWoman' => $nafaqaWoman,
            'med' => $med,
            'bs' => $bs,
            'organizations' => $organizations,
            'all' => $all,
            'railways' => $railways,
            'man' => $man,
            'woman' => $woman,
            'cadry30' => $cadry30,
            'vakant' => $vacanCount,
            'sverx' => $sverxCount,
            'dog' => $dog,
            'birthdays' => $birthdays->count(),
            'newcadries' => $newcadries->count(),
            'democadries' => $democadries->count(),
            'eduoliy' => $eduoliy,
            'edumaxsus' => $edumaxsus,
            'cadry45' => $cadry45,
            'plan' => $plan,
            'vac' => $vac,
            'vacDec' => $vacDec,
            'democadriesback' => $democadriesback->count()
        ]);
    }

    public function api_statistics(Request $request)
    {
            $all = Cadry::ApiFilter()->count();
            $man = Cadry::ApiFilter()->where('sex',1)->count();
            $woman = $all - $man;
            $dog =  Cadry::ApiFilter()->where('worklevel_id',5)->count();

            $cadry30 = Cadry::ApiFilter()->where('birht_date','>=','1992-01-01')->count();
            $cadry45 = Cadry::ApiFilter()->where('birht_date','>=','1977-01-01')->count();
            
            $medical_examinations = Cadry::ApiMedFilter()
                ->select(['cadries.*', 'medical_examinations.*'])
                ->where('cadries.status', true)
                ->where('medical_examinations.status', true)
                ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
                ->whereDate('medical_examinations.date2','<=', now())
                ->count();

            $nafaqaMan = Cadry::ApiFilter()->where('sex',1)->where('birht_date','<=','1957-01-01')->count();
            $nafaqaWoman = Cadry::ApiFilter()->where('sex',0)->where('birht_date','<=','1967-01-01')->count();

            $eduoliy = Cadry::ApiFilter()->where('education_id',1)->count();
            $edumaxsus = Cadry::ApiFilter()->where('education_id',3)->count();

            $birthdays = Cadry::ApiFilter()
                ->whereMonth('birht_date', '=', now()->format('m'))
                ->whereDay('birht_date', '=', now()->format('d'));

            $newcadries = Cadry::ApiFilter()->whereDate('created_at',now()->format('Y-m-d'));
       
            $democadries = DemoCadry::ApiFilter()->where('status',0)->whereDate('created_at',now()->format('Y-m-d'));
            $democadriesback = DemoCadry::ApiFilter()->where('status',1);
            
            $vacations = Vacation::query()
                ->where('status',true)
                ->whereDate( 'date2' , '>=' ,now() )
                ->when(request('railway_id'), function ($query, $railway_id) {
                    return $query->where('railway_id', $railway_id);     
                })->when(request('org_id'), function ($query, $org_id) {
                    return $query->where('organization_id', $org_id);     
                })->when(request('dep_id'), function ($query, $dep_id) {
                    return $query->where('id', $dep_id);     
                });
            $vacDec = $vacations->where('status_decret',true)->count();
            $vac = $vacations->count();
            
            $allStaffs = DepartmentStaff::ApiFilter();
            $plan = $allStaffs->sum('stavka');
           
            $sverx = DepartmentStaff::ApiFilter()->whereRaw('stavka < summ_stavka');
            $x = $sverx->sum('stavka');
            $y = $sverx->sum('summ_stavka');
            $sverxCount = $y - $x;
            
            $vacant = DepartmentStaff::ApiFilter()
                ->where(function ($query) {
                    $query->whereRaw('stavka > summ_stavka')
                            ->orWhere('summ_stavka', null);
                });
            $x = $vacant->sum('stavka');
            $y = $vacant->sum('summ_stavka');
            $vacanCount = $x - $y;

        return response()->json([
            'all_cadries_count' => $all,
            'pension_Man' => $nafaqaMan,
            'pension_Woman' => $nafaqaWoman,
            'cadries_man_count' => $man,
            'cadries_woman_count' => $woman,
            'vakant' => number_format($vacanCount, 2, ',', ' '),
            'sverx' => number_format($sverxCount, 2, ',', ' '),
            'contracts' => $dog,
            'birthdays' => $birthdays->count(),
            'new_cadries' => $newcadries->count(),
            'delete_cadries' => $democadries->count(),
            'BlackList' => $democadriesback->count(),
            'education_oliy' => $eduoliy,
            'education_maxsus' => $edumaxsus,
            'plan' => number_format($plan, 2, ',', ' '),
            'cadry30' => $cadry30,
            'cadry45' => $cadry45,
            'vacations' => $vac,
            'vacations_Dec' => $vacDec,
            'medical_examinations' => $medical_examinations
        ]);
    }

    public function cadry_statistics()
    {
            $all = Cadry::OrgFilter()->count();
            $man = Cadry::OrgFilter()->where('sex',1)->count();
            $woman = $all - $man;
            $dog =  Cadry::OrgFilter()->where('worklevel_id',5)->count();

            $decret =  Cadry::OrgFilter()->where('status_dec',1)->count();
            $med =  Cadry::OrgFilter()->where('status_med',1)->count();
            $bs =  Cadry::OrgFilter()->where('status_bs',1)->count();

            $cadry30 = Cadry::OrgFilter()->where('birht_date','>=','1992-01-01')->count();
            $cadry45 = Cadry::OrgFilter()->where('birht_date','>=','1977-01-01')->count();
            
            $nafaqaMan = Cadry::OrgFilter()->where('sex',1)->where('birht_date','<=','1957-01-01')->count();
            $nafaqaWoman = Cadry::OrgFilter()->where('sex',0)->where('birht_date','<=','1967-01-01')->count();

            $eduoliy = Cadry::OrgFilter()->where('education_id',1)->count();
            $edumaxsus = Cadry::OrgFilter()->where('education_id',3)->count();

            $birthdays = Cadry::OrgFilter()
                ->whereMonth('birht_date', '=', now()->format('m'))
                ->whereDay('birht_date', '=', now()->format('d'));

            $newcadries = Cadry::OrgFilter()->whereDate('created_at',now()->format('Y-m-d'));
       
            $democadries = DemoCadry::OrgFilter()->where('status',false)->whereDate('created_at',now()->format('Y-m-d'));
            $democadriesback = DemoCadry::OrgFilter()->where('status', 1);

            $allStaffs = DepartmentStaff::CadryFilter();
            $plan = $allStaffs->sum('stavka');
           
            $sverx = DepartmentStaff::CadryFilter()
                ->whereRaw('stavka < summ_stavka');

            $x = $sverx->sum('stavka');
            $y = $sverx->sum('summ_stavka');
            $sverxCount = $y - $x;

            $vacant = DepartmentStaff::CadryFilter()
                ->where(function ($query) {
                    $query->whereRaw('stavka > summ_stavka')
                            ->orWhere('summ_stavka', null);
                });
            $x = $vacant->sum('stavka');
            $y = $vacant->sum('summ_stavka');
            $vacanCount = $x - $y;
            //dd($vacant->get());

        return view('cadry.statistics', [
            'decret' => $decret,
            'plan' => $plan,
            'nafaqaMan' => $nafaqaMan,
            'nafaqaWoman' => $nafaqaWoman,
            'med' => $med,
            'bs' => $bs,
            'all' => $all,
            'man' => $man,
            'woman' => $woman,
            'cadry30' => $cadry30,
            'vakant' => $vacanCount,
            'sverx' => $sverxCount,
            'dog' => $dog,
            'birthdays' => $birthdays->count(),
            'newcadries' => $newcadries->count(),
            'democadries' => $democadries->count(),
            'eduoliy' => $eduoliy,
            'edumaxsus' => $edumaxsus,
            'cadry45' => $cadry45,
            'democadriesback' => $democadriesback->count()
        ]);
    }

    public function archive_cadry(Request $request) 
    {
        if($request->jshshir) 
            $cadries = Cadry::query()
                ->where('status', false)
                ->when(\Request::input('jshshir'),function($query, $jshshir){
                    $query->where(function ($query) use ($jshshir) {
                        $query->Where('jshshir', 'LIKE', '%'. $jshshir .'%');
                    });
                });
             else
        $cadries = Cadry::where('jshshir',777777777777)->where('status',false);

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        return view('cadry.archive_cadry',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
        ]);
    }

    public function cadry_archive_load($id) 
    {

        $cadry = Cadry::find($id);

        return view('cadry.cadry_archive_load',[
            'cadry' => $cadry
        ]);
    }

    public function save_archive_cadry($id, Request $request)
    {
        $org_id = auth()->user()->userorganization->organization_id;
        $rail_id = auth()->user()->userorganization->railway_id;

        $dep = DepartmentStaff::with('cadry')->find($request->staff_id);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $rail_id;
            $newItem->organization_id = $org_id;
            $newItem->department_id = $request->department_id;
            $newItem->department_staff_id = $request->staff_id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->staff_date;
            $newItem->staff_status = $request->staff_status;

            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->st_1) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;

                $newItem->cadry_id = $id;
                $newItem->stavka = $request->st_1;
                $newItem->save();
                
                $cadr = Cadry::find($id);
                $cadr->railway_id = $rail_id;
                $cadr->organization_id = $org_id;
                $cadr->department_id = $request->department_id;
                $cadr->post_name = $dep->staff_full;
                $cadr->status = true;
                $cadr->save();

                $x = Career::where('cadry_id',$id)->count();
                $y = new Career();
                $y->sort = $x + 1;
                $y->cadry_id = $id;
                $y->date1 = date("Y", strtotime($request->staff_date));
                $y->date2 = '';
                $y->staff = $dep->staff_full;
                $y->save();

        return redirect()->route('cadry')->with('msg',5);
    }

    public function ssss(Request $request)
    { 
       for($i = 0; $i <= 99; $i ++)
       {
         $item = new StavkaDou();
         $item->val_dou = $i;
         $item->save();
       }
    }

    public function userPhone()
    {

        set_time_limit(3000);
       
        $cadries = CadryRelative::select('cadry_id')->groupBy('cadry_id')->get();
        $x = 0; $a = [];
        foreach($cadries as $item)
        {
            if(!Cadry::find($item->cadry_id)) 
            {
                //CadryRelative::where('cadry_id',$item->cadry_id)->delete();
                $x++; $a[$x] = $item->cadry_id;
            }
        }
        //CadryRelative::whereIn('cadry_id',$a)->delete();
        dd($x);

        set_time_limit(600);
       
        $cadries = Cadry::where('status',true)->has('careers', '=', 0)->with('organization')->get();

        $x = []; $y = 0;
        foreach($cadries as $item){
            $y ++;
            $x[$y] = $item->organization->name . '#' . $item->last_name . ' ' . $item->first_name . ' ' . $item->middle_name;
        }

        dd($x);
    }

    public function add_filestaff_cadry($id, Request $request)
    {
        $fileName = time().'.'.$request->file_path->extension();

        $path = $request->file_path->storeAs('stafffiles', $fileName);

        $newfile = new StaffFile();
        $newfile->cadry_id = $id;
        $newfile->comment = $request->comment;
        $newfile->file_path = 'storage/' . $path;
        $newfile->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_stafffile_cadry($id, Request $request)
    {
        $fileName = time().'.'.$request->file_path->extension();

        $path = $request->file_path->storeAs('stafffiles', $fileName);

        $newfile =  StaffFile::find($id);
        $newfile->comment = $request->comment;
        $newfile->file_path = 'storage/' . $path;
        $newfile->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_stafffile_cadry($id)
    {
        $newfile =  StaffFile::find($id)->delete();
        return redirect()->back()->with('msg' ,1);
    }

    public function loadcity(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = City::where('name', 'like', '%' . $search . '%')->get();
        }
        return response()->json($data);
    }

    public function loadCareer(Request $request)
    {
        $data = [];
        if ($request->has('cadry_id')) {
            $id = $request->cadry_id;
            $data = Career::where('cadry_id', $id )->orderBy('id', 'desc')->get();
        }
        return response()->json($data);
    }

}
