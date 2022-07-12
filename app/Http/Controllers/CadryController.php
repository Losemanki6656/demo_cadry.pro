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

use Auth;

class CadryController extends Controller
{

    public function index(Request $request)
    {
       // dd($request->all());
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
       
        $cadries = Cadry::FullFilter();

        $staffs = Staff::where('organization_id',$org_id)->get();
        $regions = Region::all();
        $departments = Department::where('organization_id',$org_id)->get(); 

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        return view('cadry.cadry',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
            'staffs' => $staffs,
            'regions' => $regions,
            'departments' => $departments
        ]);
    }
    
    public function decret_cadry($id)
    {
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
       
        $fullcadries = Cadry::where('organization_id', $org_id)->get();
        $item = Cadry::find($id);

        return view('cadry.decret',[
            'fullcadries' => $fullcadries,
            'item' => $item
        ]);
    }

    public function cadry_department($id)
    {
        $cadries = Cadry::query()
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
        ->where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
        ->when(\Request::input('search'),function($query,$search){
            $query
            ->where('name','like','%'.$search.'%');
        })
        ->with('cadries')->paginate(10);

        $con = 0;
        $arr = [];

        foreach($staffs as $item)
        {
            $arr[$item->id] = array_sum($item->cadries->pluck('stavka')->toArray());
        }

        $categories = Category::all();

        return view('cadry.staff',[
            'staffs' => $staffs,
            'categories' => $categories,
            'arr' => $arr
        ]);
    }

    public function departments()
    {

        $departments = Department::query()->where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
        ->when(\Request::input('search'),function($query,$search){
            $query
            ->where('name','like','%'.$search.'%');
        })->with('cadries');

        return view('cadry.departments',[
            'departments' => $departments->paginate(10)
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
        Department::find($id)->delete();

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
        $cadry = Cadry::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('staff')->find($id);
        $departments = Department::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->get();
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
        $cadry = Cadry::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('staff')->find($id);
        $railways = Railway::all();
        $info = Education::all();
        $academictitle = AcademicTitle::all();
        $academicdegree = AcademicDegree::all();
        $naties = Nationality::all();
        $langues = Language::all();
        $parties = Party::all();
        $worklevel = WorkLevel::all();

        $infoeducations = InfoEducation::where('cadry_id',$id)->get();
        $institut = Institut::all();

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
            'institut' => $institut
        ]);
    }

    public function cadry_career($id)
    {
        $cadry = Cadry::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('staff')->find($id);
     
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
        $cadry = Cadry::where('organization_id',UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('staff')->find($id);

        $meds = MedicalExamination::where('cadry_id',$cadry->id)->get();
        $discips = DisciplinaryAction::where('cadry_id',$cadry->id)->get();
        $incentives = Incentive::where('cadry_id',$cadry->id)->get();

        return view('cadry.cadry-other',[
            'cadry' => $cadry,
            'meds' => $meds,
            'discips' => $discips,
            'incentives' => $incentives
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
       // dd($request->all());
        $array = $request->all();
        $array['railway_id'] = UserOrganization::where('user_id',Auth::user()->id)->value('railway_id');
        $array['organization_id'] = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $cadry = Cadry::create($array);

        return redirect()->route('cadry_edit',[$cadry->id]);
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

    public function add_med_cadry(Request $request, $id)
    {
        $med = new MedicalExamination();
        $med->cadry_id = $id;
        $med->date1 = $request->date1;
        $med->result = $request->result ?? '';
        $med->date2 = $request->date2;
        $med->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_med_cadry(Request $request, $id)
    {
        $med = MedicalExamination::find($id);
        $med->date1 = $request->date1;
        $med->result = $request->result ?? '';
        $med->date2 = $request->date2;
        $med->save();

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
        $arr = Cadry::find($id)->toArray();
        $arr['number'] = $request->number ?? '';
        $arr['comment'] = $request->comment ?? '';
        $arr['cadry_id'] = $request->id;

        DemoCadry::create($arr);
        Cadry::find($id)->delete();

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
            $y = 0;
            $a = [];

            foreach ($arr as $row) { 
            $cadry = DemoCadry::create([
                    'cadry_id' => 0,
                    'railway_id' => $row[9],
                    'organization_id' => $row[10],
                    'department_id' => 0,
                    'birth_region_id' => 0,
                    'birth_city_id' => 0,
                    'category_id' => 0,
                    'pass_region_id' => 0,
                    'pass_city_id' => 0,
                    'address_region_id' =>0,
                    'address_city_id' => 0,
                    'education_id' => 0,
                    'staff_id' => 0,
                    'stavka' => "1",
                    'photo' => "-",
                    'phone' => "-",
                    'nationality_id' => 1,
                    'party_id' => 3,
                    'academictitle_id' => 3,
                    'academicdegree_id' => 5,
                    'worklevel_id' => 3,
                    'military_rank' => "Yo'q",
                    'deputy' => "Yo'q",
                    'language' => "1,2",
                    'last_name' => $row[1],
                    'first_name' => $row[2],
                    'middle_name' => $row[3] ?? ' ',
                    'birht_date' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d'),
                    'post_date' => '2022-02-02',
                    'post_name' => $row[5] ?? '',
                    'passport' => '',
                    'jshshir' => $row[6] ?? '',
                    'pass_date' => '2022-02-02',
                    'address' =>  '',
                    'sex' => '1',
                    'number' =>  'P0',
                    'comment' => $row[7],
                    'status' => 1,
                    'job_date' =>  \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]))->format('Y-m-d'),
                ]);

                $x ++;
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

            $staffs = Staff::filter()->get();

            $all = Cadry::filter()->count();
            $man = Cadry::filter()->where('sex',1)->count();
            $woman = $all - $man;
            $dog =  Cadry::filter()->where('worklevel_id',5)->count();

            $decret =  Cadry::filter()->where('status_dec',1)->count();
            $med =  Cadry::filter()->where('status_med',1)->count();
            $bs =  Cadry::filter()->where('status_bs',1)->count();

            $vakant = 0;
            $sverx = 0;

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


            $y = 0; $z = 0;
            foreach ( $staffs as $staf) {
                $y = $y + (int)$staf->staff_count;
                $x = $staf->cadries->count();
                $z = $z + $x;
                if( $x <= (int)$staf->staff_count)  {
                    $vakant = $vakant + (int)$staf->staff_count - $x; 
                }
                    else
                        $sverx = $sverx + $x - (int)$staf->staff_count;
            } 

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
            'vakant' => $vakant,
            'sverx' => $sverx,
            'staffs' => $staffs,
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

    public function cadry_statistics()
    {
     
            $staffs = Staff::OrgFilter()->get();

            $all = Cadry::OrgFilter()->count();
            $man = Cadry::OrgFilter()->where('sex',1)->count();
            $woman = $all - $man;
            $dog =  Cadry::OrgFilter()->where('worklevel_id',5)->count();

            $decret =  Cadry::OrgFilter()->where('status_dec',1)->count();
            $med =  Cadry::OrgFilter()->where('status_med',1)->count();
            $bs =  Cadry::OrgFilter()->where('status_bs',1)->count();

            $vakant = 0;
            $sverx = 0;

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
       
            $democadries = DemoCadry::OrgFilter()->where('status',0)->whereDate('created_at',now()->format('Y-m-d'));
            $democadriesback = DemoCadry::OrgFilter()->where('status',1);

            $y = 0; $z = 0;
            foreach ( $staffs as $staf) {
                $y = $y + (int)$staf->staff_count;
                $x = $staf->cadries->count();
                $z = $z + $x;
                if( $x <= (int)$staf->staff_count)  {
                    $vakant = $vakant + (int)$staf->staff_count - $x; 
                }
                    else
                        $sverx = $sverx + $x - (int)$staf->staff_count;
            } 

        return view('cadry.statistics', [
            'decret' => $decret,
            'nafaqaMan' => $nafaqaMan,
            'nafaqaWoman' => $nafaqaWoman,
            'med' => $med,
            'bs' => $bs,
            'all' => $all,
            'man' => $man,
            'woman' => $woman,
            'cadry30' => $cadry30,
            'vakant' => $vakant,
            'sverx' => $sverx,
            'staffs' => $staffs,
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
        //dd($request->all());
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $cadries = DemoCadry::DemoFilter();

        $staffs = Staff::where('organization_id',$org_id)->get();
        $regions = Region::all();
        $departments = Department::where('organization_id',$org_id)->get();

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        return view('cadry.archive_cadry',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
            'staffs' => $staffs,
            'regions' => $regions,
            'departments' => $departments
        ]);
    }

    public function ssss()
    {
      return view('auth.login2');
    }

    public function userPhone()
    {
        $users = UserOrganization::with('organization')->get();
        $a = []; $x = 0;
      foreach ($users as $user){
        if($user->post_id == 1 && $user->phone == "998977226656") {
            $x++;
            $a[$x] = $user->railway->name.">".$user->organization->name;
        }
      }

      dd($a);
    }

}
