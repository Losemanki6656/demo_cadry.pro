<?php

namespace App\Http\Controllers;

use App\Models\Cadry;
use App\Models\DemoCadry;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Incentive;
use App\Models\UserOrganization;
use App\Models\Railway;
use App\Models\Vacation;
use App\Models\Staff;
use App\Models\User;
use App\Models\Career;
use App\Models\Turnicet;
use App\Models\Region;
use App\Models\Reception;
use App\Models\Language;
use App\Models\CadryRelative;
use App\Models\AuthenticationLog;
use App\Models\InfoEducation;
use App\Models\Revision;
use App\Models\Education;
use App\Models\DepartmentCadry;
use App\Models\DepartmentStaff;
use App\Models\DisciplinaryAction;
use App\Models\AcademicTitle;
use App\Models\AcademicDegree;
use App\Models\Institut;
use App\Models\Nationality;
use App\Models\AbroadStudy;
use App\Models\AcademiStudy;
use App\Models\Abroad;
use App\Models\WorkStatus;
use App\Models\AcademicName;
use App\Models\MedicalExamination;
use App\Models\Party;
use App\Models\City;
use App\Models\UserTask;
use App\Models\WorkLevel;
use App\Jobs\ExportWorkersToZip;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\CareerExport;
use App\Exports\RelativeExport;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RailwayResource;
use App\Http\Resources\MedicalResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\CadryResource;
use App\Http\Resources\CadryCollection;
use App\Http\Resources\OrgResource;
use App\Http\Resources\DepResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\StaffResource;
use App\Http\Resources\WordExportCadryResource;
use App\Http\Resources\InfoEducationResource;
use App\Http\Resources\CareerResource;
use App\Http\Resources\RelativesResource;
use App\Http\Resources\OrganizationCadryResource;
use App\Http\Resources\VacationResource;
use App\Http\Resources\OrganizationCadryCollection;
use App\Http\Resources\CityResource;
use App\Http\Resources\WorkLevelResource;
use App\Http\Resources\AcademicTitleResource;
use App\Http\Resources\AcademicDegreeResource;
use App\Http\Resources\NationalityResource;
use App\Http\Resources\PartyResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\InstitutResource;
use App\Http\Resources\AbroadStudyResource;
use App\Http\Resources\AcademicStudyResource;
use App\Http\Resources\AbroadResource;
use App\Http\Resources\AcademicResource;
use App\Http\Resources\DepartmentStaffResource;
use App\Http\Resources\DisciplinaryActionResource;
use App\Http\Resources\IncentiveResource;
use App\Http\Resources\WorkStatusResource;
use Auth;
use File;
use DB;


class OrganizationController extends Controller
{
    public function index(Request $request)
    {
       // dd($request->all());
        $railways = Railway::all();
        $regions = Region::all();
        $organizations = Organization::query()->where('railway_id', request('railway_id', 0))->get();
        $departments = Department::query()->where('organization_id', request('org_id', 0))->get();
        
        $cadries = Cadry::filter()
            ->orderBy('org_order','asc')
            ->orderBy('dep_order','asc')
            ->with(['address_region', 'address_city']);     
   
        $countcadries = $cadries->count();

        $staffs = Staff::query()->where('organization_id', request('org_id', 0))->with('organization')->with('category')->with('cadries')->paginate(10);

        return view('uty.organizations', [
            'departments' => $departments,
            'organizations' => $organizations,
            'railways' => $railways,
            'cadries' => $cadries->paginate(10),
            'staffs' => $staffs,
            'countcadries' => $countcadries,
            'regions' => $regions
        ]);
    }

    public function api_cadries(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        $cadries = Cadry::ApiOrgFilter()
            ->with(['vacation','allStaffs','department'])->paginate($per_page, ['*'], 'page', $page);
    
        return response()->json([
            'cadries' => new OrganizationCadryCollection($cadries)
        ]);
    }

    public function api_cadry_leader_cadries(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $page = request('page', session('cadry_page', 1));
        session(['cadry_page' => $page]);

        $cadries = Cadry::ApiLeaderFilter()
            ->with(['vacation','allStaffs','department','organization'])->paginate($per_page, ['*'], 'page', $page);
    
        return response()->json([
            'cadries' => new OrganizationCadryCollection($cadries)
        ]);
    }

    public function api_organizations(Request $request)
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $cadries = Cadry::ApiFilter()
            ->orderBy('org_order','asc')
            ->orderBy('dep_order','asc')
            ->with(['address_region', 'address_city','organization','railway','organization','allStaffs']);
    
        return response()->json([
            'cadries' =>  new CadryCollection($cadries->paginate($per_page)),
        ]);
    }
    public function filter_api_organizations(Request $request)
    {
        $data = [];
        if ($request->has('railway_id')) {
            $data = OrgResource::collection(Organization::where('railway_id',$request->railway_id)->get());
        }
        return response()->json($data);
    }

    public function filter_api_railways(Request $request)
    {
        $data = RailwayResource::collection(Railway::all());
        if ($request->has('name')) {
            $search = $request->name;
            $data = RailwayResource::collection(Railway::where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->get());
        }
        return response()->json($data);
    }

    public function filter_api_staffs(Request $request)
    {
        $data = [];

        if ($request->has('organization_id')) {
            $data = StaffResource::collection(Staff::where('organization_id',$request->organization_id)->get());
        }

        return response()->json($data);
    }

    public function filter_api_departments(Request $request)
    {
        $data = [];

        if ($request->has('organization_id')) {
            $data = DepResource::collection(Department::where('organization_id',$request->organization_id)->where('status', true)->get());
        }

        return response()->json($data);
    }

    public function filter_api_org_departments()
    {
        $data = DepResource::collection(Department::where('organization_id',auth()->user()->userorganization->organization_id)->get());

        return response()->json($data);
    }

    public function filter_api_org_staffs()
    {
        $data = StaffResource::collection(Staff::where('organization_id',auth()->user()->userorganization->organization_id)->where('status',true)->get());

        return response()->json($data);
    }

    public function filter_api_regions()
    {   
        $data = RegionResource::collection(Region::get());

        return response()->json($data);
    }

    public function filter_api_worklevels()
    {   
        $data = WorkLevel::get();

        // $data = WorkLevel::get();

        return response()->json($data);
    }
    
    public function filter_api_cities(Request $request)
    {   
        $data = CityResource::collection(
            City::query()
            ->when(\Request::input('region_id'),function($query,$region_id){
                $query->where('region_id',$region_id);
            })->get());

        return response()->json($data);
    }

    public function filter_api_academicTitlies()
    {   
        $data = AcademicTitleResource::collection(AcademicTitle::get());

        return response()->json($data);
    }

    public function filter_api_academicDegree()
    {   
        $data = AcademicDegreeResource::collection(AcademicDegree::get());

        return response()->json($data);
    }

    public function filter_api_nationalities()
    {   
        $data = NationalityResource::collection(Nationality::get());

        return response()->json($data);
    }

    public function filter_api_parties()
    {   
        $data = PartyResource::collection(Party::get());

        return response()->json($data);
    }

    public function filter_api_languages()
    {   
        $data = LanguageResource::collection(Language::get());

        return response()->json($data);
    }

    public function filter_api_instituts()
    {   
        $data = InstitutResource::collection(Institut::get());

        return response()->json($data);
    }

    public function filter_api_abroads()
    {   
        $data = AbroadResource::collection(Abroad::get());

        return response()->json($data);
    }

    public function filter_api_academics()
    {   
        $data = AcademicResource::collection(AcademicName::get());

        return response()->json($data);
    }

    public function filter_api_educations()
    {
        $data = EducationResource::collection(Education::get());

        return response()->json($data);
    }

    public function filter_api_vacations()
    {
        $data = [
            [
                'id' => 1,
                'name' => "Mehnat ta'tili"
            ],
            [
                'id' => 2,
                'name' => "Bola parvarish ta'tili"
            ]
        ];

        return response()->json($data);
    }

    public function filter_api_regions_a()
    {   
        $data = RegionResource::collection(Region::get());

        return response()->json($data);
    }
    
    public function loadvacan(Request $request)
    {
        
        $data = DepartmentStaffResource::collection(DepartmentStaff::where('department_id', $request->department_id)->get());

        return response()->json($data, 200);
    }

    public function download_resume($cadry_id){

        $cadry = Cadry::with([
            'allstaffs',
            'birth_region',
            'birth_city',
            'nationality',
            'party',
            'education',
            'instituts',
            'cadry_degree',
            'cadry_title',
            'incentives',
            'careers',
            'relatives',
            'relatives.relative'
        ])->find($cadry_id);

        $languages = Language::all();

        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(base_path('public_html/example_resume.docx'));
        $fullname = $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name;
        $fullname_rel = $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name . 'ning';

        if(count($cadry->allstaffs->where('staff_status',false)) > 0 )
            $post = $cadry->allstaffs->where('staff_status',false)->first();
        else 
            $post = $cadry->allstaffs->first();
        $birth_address = $cadry->birth_region->name . ', ' . $cadry->birth_city->name;

        $instituts = '';
        $i = 0;
        foreach($cadry->instituts as $ins)
        {
            if($i != 0) $instituts = $instituts . ', ';
            $instituts = $instituts . $ins->date2 . ' yil,' . $ins->institut;
            $i ++; 
        }
        $specs = $cadry->instituts->pluck('speciality')->toArray();
        $specs = implode(',',$specs);

        $lan = '';
        foreach ($languages as $language) {
           if (in_array($language->id, explode(',',$cadry->language) )) 
                $lan = $lan.$language->name.',';
        }
        $lan = substr_replace($lan ,'', -1);

        $types = $cadry->incentives->pluck('type_action')->toArray();
        $type_actions = implode(',', $types);
        if(!$type_actions) $type_actions = 'taqdirlanmagan';

        
        $careers = $cadry->careers;
        $car = []; 
        foreach($careers as $career)
        {
            if($career->date2 == '') $dat = $career->date1 . ' h/v '; else $dat = $career->date1 . '-' . $career->date2 . ' yy - ';

            $car[] = [
                        'career_date' => $dat, 
                        'career_name' => $career->staff
                    ];
        }
        $my_template->cloneRowAndSetValues('career_date', $car);

        $cadry_relatives = $cadry->relatives;
        $rels = []; 
        foreach($cadry_relatives as $rel)
        {
            $rels[] = [
                        'relative' => $rel->relative->name, 
                        'relative_name' => $rel->fullname, 
                        'relative_date' => $rel->birth_place, 
                        'relative_staff' => $rel->post, 
                        'relative_address' => $rel->address
                    ];
        }
        $my_template->cloneRowAndSetValues('relative', $rels);

        $my_template->setValue('fullname', $fullname);
        $my_template->setImageValue('photo', array('path' => base_path('public_html/storage/'. $cadry->photo), 'width' => 113, 'height' => 149, 'ratio' => false));
        $my_template->setValue('staff_date', $post->staff_date . 'dan');
        $my_template->setValue('staff_full', $post->staff_full);
        $my_template->setValue('birth_date', $cadry->birht_date);
        $my_template->setValue('birth_address', $birth_address);
        $my_template->setValue('nationality', $cadry->nationality->name);
        $my_template->setValue('party', $cadry->party->name);
        $my_template->setValue('education', $cadry->education->name);
        $my_template->setValue('institut', $instituts);
        $my_template->setValue('speciality', $specs);
        $my_template->setValue('academic_degree', $cadry->cadry_degree->name);
        $my_template->setValue('academic_title', $cadry->cadry_title->name);
        $my_template->setValue('languages', $lan);
        $my_template->setValue('incent', $type_actions);
        $my_template->setValue('military_rank', $cadry->military_rank);
        $my_template->setValue('deputy', $cadry->deputy);
        $my_template->setValue('fullname_rel', $fullname_rel);       
     
        try{
            $my_template->saveAs(base_path('public_html/storage/resumes/' . $cadry->jshshir . '.docx'));
        }catch (Exception $e){
        }
    
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return response()->download(base_path('public_html/storage/resumes/' .  $cadry->jshshir  . '.docx'), $fullname .'.docx', $headers)->deleteFileAfterSend(true);
    }

    public function cadries_info()
    {
        $work_statuses = WorkStatusResource::collection(WorkStatus::get());
        $data1 = RegionResource::collection(Region::get());
        $data2 = CityResource::collection(City::get());
        $data3 = DepResource::collection(Department::where('organization_id',auth()->user()->userorganization->organization_id)->get());
       // $data = StaffResource::collection(Staff::where('organization_id',auth()->user()->userorganization->organization_id)->get());
        $data4 = NationalityResource::collection(Nationality::get());
        $data5 = LanguageResource::collection(Language::get());
        $data6 = AcademicTitleResource::collection(AcademicTitle::get());
        $data7 = AcademicDegreeResource::collection(AcademicDegree::get());
        $data8 = PartyResource::collection(Party::get());
        $data9 = WorkLevel::get();
        
        // $data9 = WorkLevel::get();

        $data10 = EducationResource::collection(Education::get());

        return response()->json([
            'work_statuses' => $work_statuses,
            'regions' => $data1,
            'cities' => $data2,
            'departments' => $data3,
            'nationalities' => $data4,
            'languages' => $data5,
            'academictitlies' => $data6,
            'academicdegree' => $data7,
            'parties' => $data8,
            'worklevels' => $data9,
            'educations' => $data10
        ]);
    }

    public function filter_api_cadry_informations()
    {
        $data1 = AcademicTitleResource::collection(AcademicTitle::get());
        $data2 = AcademicDegreeResource::collection(AcademicDegree::get());
        $data3 = NationalityResource::collection(Nationality::get());
        $data4 = LanguageResource::collection(Language::get());
        $data5 = PartyResource::collection(Party::get());
        $data6 = EducationResource::collection(Education::get());

        return response()->json([
            'academicTitlies' => $data1,
            'academicDegree' => $data2,
            'nationalities' => $data3,
            'languages' => $data4,
            'parties' => $data5,
            'educations' => $data6
        ]);
    }

    public function word_export_api($id){

        $languages = Language::all();
        $cadry = new WordExportCadryResource(Cadry::with(['birth_city','birth_region','instituts'])->find($id));
        $lan = "";
        foreach ($languages as $language) {
           if (in_array($language->id, explode(',',$cadry->language) )) 
                $lan = $lan.$language->name.',';
        }
        $lan = substr_replace($lan ,"", -1);
        $carers = Career::where('cadry_id',$id)->orderBy('sort','asc')->get();
        $cadry_relatives = CadryRelative::where('cadry_id',$id)->with('relative')->orderBy('sort','asc')->get();
        $incentives = Incentive::where('cadry_id',$id)->get();
        $discips = DisciplinaryAction::where('cadry_id',$id)->get();
        $meds = MedicalExamination::where('cadry_id',$id)->get();
        $vacations = Vacation::where('cadry_id',$id)->get();

        return response()->json([
            'cadry' => $cadry,
            'lan' => $lan,
            'educations' =>  InfoEducationResource::collection($cadry->instituts),
            'carers' => CareerResource::collection($carers),
            'relatives' =>  RelativesResource::collection($cadry_relatives),
            'incentives' => IncentiveResource::collection($incentives),
            'discips' => DisciplinaryActionResource::collection($discips),
            'vacations' => VacationResource::collection($vacations),
            'meds' => MedicalResource::collection($meds)
        ]);

    }

    public function cadry_leader()
    {
        $railway_id = UserOrganization::where('user_id',Auth::user()->id)->value('railway_id');
        $railways = Railway::find($railway_id);
        $organizations = Organization::where('railway_id', $railway_id)->get();
        $departments = Department::query()->where('organization_id', request('org_id', 0))->get();
        
        $cadries = Cadry::query()
        ->where('status',true)
            ->with(['address_region', 'address_city'])
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->Orwhere('last_name','like','%'.$search.'%')
                        ->orWhere('first_name','like','%'.$search.'%')
                        ->orWhere('middle_name','like','%'.$search.'%');
                });
            })
            ->when(request('org_id'), function (Builder $query, $org_id) {
                return $query->where('organization_id', $org_id);

            })->when(request('dep_id'), function (Builder $query, $dep_id) {
                return $query->where('department_id', $dep_id);

            })->where('railway_id', $railway_id);

            $countcadries = $cadries->count();

        $staffs = Staff::query()->where('organization_id', request('org_id', 0))->with('organization')->with('category')->with('cadries')->paginate(10);

        return view('cadry_leader.organizations', [
            'departments' => $departments,
            'organizations' => $organizations,
            'railways' => $railways,
            'cadries' => $cadries->paginate(10),
            'staffs' => $staffs,
            'countcadries' => $countcadries
        ]);
    }

    
    public function shtat(Request $request)
    {
        $organization = Organization::find($request->organization_id);

        $staffs = Staff::query()
        ->where('organization_id', $request->organization_id)
        ->when(request('search'), function ($query, $search) {
            return $query
                ->where('name', 'like', '%' . $search . '%');
        })
        ->with('organization')->with('category')->with('cadries')->paginate(10);

        return view('uty.shtat', [
            'staffs' => $staffs,
            'organization' => $organization
        ]);
    }

    public function cadry_view($id)
    {
        $cadry = Cadry::find($id);
        return view('uty.cadry_view', [
            'cadry' => $cadry
        ]);
    }
    
    public function cadry_downlaod($id) 
    {
        

    }

    public function word_export($id){

        $languages = Language::all();
        $cadry = Cadry::find($id);
        $lan = "";
        foreach ($languages as $language) {
           if (in_array($language->id, explode(',',$cadry->language) )) 
                $lan = $lan.$language->name.',';
        }
        $lan = substr_replace($lan ,"", -1);
        $carers = Career::where('cadry_id',$id)->orderBy('sort','asc')->get();
        $cadry_relatives = CadryRelative::where('cadry_id',$id)->orderBy('sort','asc')->get();
        $incentives = Incentive::where('cadry_id',$id)->get();

        $headers = array(

            "Content-type"=>"text/html",
    
            "Content-Disposition"=>"attachment;Filename=".$cadry->first_name.".doc"
    
        );

        $content = view('uty.cadry_view',[
            'cadry' => $cadry,
            'lan' => $lan,
            'carers' => $carers,
            'cadry_relatives' => $cadry_relatives,
            'incentives' => $incentives
        ])->render();

        return \Response::make($content, 200, $headers);
    }

    public function word_export_archive_api(Request $request){

        $tasks = UserTask::where('user_id', auth()->user()->id)->count();

        if($tasks >= 3) 
            return response()->json([
                'message' => "3 martadan ortiq ma'lumot yuklashga ruxsat etilmadi!"
            ], 403);

        if($request->send_all) {

            if($request->not_send_arr) {

                $cadries = Cadry::ApiOrgFilter()->whereNotIn('id', $request->not_send_arr)
                    ->with(['careers' => function($query){
                        $query->orderBy('sort','asc');
                    },'relatives' => function($query){
                        $query->orderBy('sort','asc');
                    },'incentives']);
                
            } else {
                
                $cadries = Cadry::ApiOrgFilter()
                    ->with(['careers' => function($query){
                        $query->orderBy('sort','asc');
                    },'relatives' => function($query){
                        $query->orderBy('sort','asc');
                    },'incentives']);

            }

        } else {

            if(!$request->send_arr) 
            
            return response()->json([
                'message' => "Ma'lumotlarni yuklash uchun yetarli ro'yxat shakllanmadi !"
            ], 400);

            $cadries = Cadry::whereIn('id', $request->send_arr)
                ->with(['careers' => function($query){
                    $query->orderBy('sort','asc');
                },'relatives' => function($query){
                    $query->orderBy('sort','asc');
                },'incentives']);

        }

        if($request->passport_files) $cadries = $cadries->with('passport_file')->get(); else $cadries = $cadries->get();

        $languages = Language::get();

        $newTask = new UserTask();
        $newTask->user_id = auth()->user()->id;
        $newTask->comment = $request->comment;
        $newTask->save();

        $emailJobs = new ExportWorkersToZip($cadries, $languages, auth()->user()->id, $request->comment, $request->passport_files, $newTask->id);

        $this->dispatch($emailJobs);
       
        return response()->json([
            'message' => "Ma'lumotlarni yuklash topshiriqlarga yuborildi!"
        ]);
       
    }

    public function export_excel(Request $request)
    {
      
        return Excel::download(new UsersExport($request->all()), 'exodim.xlsx');
    }

    public function demo_to_cadry($id)
    {
        $cadry = DemoCadry::find($id)->toArray();
        $cadry = Cadry::create($cadry);
        //dd($cadry);
        return redirect()->back()->with('msg' ,1);
    }

    public function demo_to_delete($id)
    {
        $cadry = DemoCadry::find($id)->delete();
        return redirect()->back()->with('msg' ,1);
    }

    public function incentives()
    {
        $cadries = Cadry::query()->where('status',true)
        ->where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
        ->when(\Request::input('search'),function($query,$search){
            $query->where(function ($query) use ($search) {
                $query->Orwhere('last_name','like','%'.$search.'%')
                    ->orWhere('first_name','like','%'.$search.'%')
                    ->orWhere('middle_name','like','%'.$search.'%');
            })->with(['incentives','discips']);
        });

    $page = request('page', session('cadry_page', 1));
    session(['cadry_page' => $page]);

    return view('cadry.incentives',[
        'cadries' => $cadries->paginate(10, ['*'], 'page', $page)
    ]);

    }

    public function cadry_staff_organ($id)
    {
        $org = Staff::find($id)->organization_id;

        $cadries = Cadry::query()
            ->where('organization_id', $org)
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

        return view('uty.cadry_staff',[
            'cadries' => $cadries->paginate(10, ['*'], 'page', $page),
            'staff_name' => $staff_name
        ]);
    }

    public function success_message(Request $request)
    {
        
    }

    public function user_edit()
    {
        $user = UserOrganization::where('user_id',Auth::user()->id)->with('organization')->get();

        return view('users.user-edit',[
            'user' => $user
        ]);   
    }

    public function user_edit_success($id, Request $request)
    {
      
        if($request->photo) {

            $fileName   = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('users/' . $fileName, File::get($request->photo));
            $file_name  = $request->photo->getClientOriginalName();
            $file_type  = $request->photo->getClientOriginalExtension();
            $filePath   = 'storage/users/' . $fileName;

            $userOrgan = UserOrganization::find($id);
            $userOrgan->photo = $filePath;
            $userOrgan->phone = $request->phone;
            $userOrgan->post_id = $request->password;
            $userOrgan->save();

            $user = User::find(Auth::user()->id);
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('home')->with('msg' , 1);

        } else  {

            $userOrgan = UserOrganization::find($id);
            $userOrgan->phone = $request->phone;
            $userOrgan->post_id = $request->password;
            $userOrgan->save();

            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('home')->with('msg' , 1);
        }
    }

    public function turnicet()
    {
        $controls = Turnicet::query()
            ->when(\Request::input('search'),function($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->Orwhere('fullname','like','%'.$search.'%')
                        ->orWhere('organization_name','like','%'.$search.'%')
                        ->orWhere('tabel','like','%'.$search.'%');
                });
            })->orderBy('created_at','desc')->paginate(10);

        return view('uty.turnicet',[
            'controls' => $controls
        ]);
    }

    public function vacation($id, Request $request)
    {
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');
        $railway_id = UserOrganization::where('user_id',Auth::user()->id)->value('railway_id');

        $vacations = Vacation::where('cadry_id',$id)->where('status',true)->get();
        foreach($vacations as $vac){
            $vac->status = false;
            $vac->save();
        }

        $item = new Vacation();
        $item->railway_id = $railway_id;
        $item->organization_id = $org_id;
        $item->cadry_id = $id;
        $item->date1 = $request->date1;
        $item->date2 = $request->date2;
        $item->date_next = $request->datenext;
        $item->status = true;
        $item->save();

        return redirect()->back()->with('msg' , 1);
    }

    public function krilltolatin(Request $request)
    {
        
        $cyr = [
            'а','б','в','г','д',' е','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д'," Е",'Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Қ','қ','Ў','ў','Ғ','ғ','Ҳ','ҳ', '"'
        ];

        $lat = [
            'a','b','v','g','d'," ye",'e','yo','j','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','x','ts',"ch","sh","sh","'",'i',"",'e','yu','ya',
            'A','B','V','G','D'," Ye","Ye","Yo",'J','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','X','Ts',"Ch",'Sh','Sht',"'",'I',"",'E','Yu','Ya','Q','q',"O'","o'","G'","g'",'H','h', ''
        ];

        $item = Cadry::find($request->id);

        $item->last_name = str_replace($cyr, $lat, $item->last_name);
        $item->first_name = str_replace($cyr, $lat, $item->first_name);
        $item->middle_name = str_replace($cyr, $lat, $item->middle_name);
        $item->post_name = str_replace($cyr, $lat, $item->post_name);
        $item->address = str_replace($cyr, $lat, $item->address);

        $department = Department::find($item->department_id);
        $department->name = str_replace($cyr, $lat, $department->name);
        $department->save();

        $staff = Staff::find($item->staff_id);
        $staff->name = str_replace($cyr, $lat, $staff->name);
        $staff->save();

        $infos = InfoEducation::where('cadry_id',$request->id)->get();

        foreach($infos as $info)
        {
            $info->institut = str_replace($cyr, $lat, $info->institut);
            $info->speciality = str_replace($cyr, $lat, $info->speciality);
            $info->save();
        }

        $careers = Career::where('cadry_id',$request->id)->get();

        foreach($careers as $career)
        {
            $career->staff = str_replace($cyr, $lat, $career->staff);
            $career->save();
        }

        $careers = Career::where('cadry_id',$request->id)->get();

        foreach($careers as $career)
        {
            $career->staff = str_replace($cyr, $lat, $career->staff);
            $career->save();
        }

        $relatives = CadryRelative::where('cadry_id',$request->id)->get();

        foreach($relatives as $relative)
        {
            $relative->fullname = str_replace($cyr, $lat, $relative->fullname);
            $relative->birth_place = str_replace($cyr, $lat, $relative->birth_place);
            $relative->post = str_replace($cyr, $lat, $relative->post);
            $relative->address = str_replace($cyr, $lat, $relative->address);
            $relative->save();
        }

        $item->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'zgartirildi!"
        ], 200);
    }

    public function newcadries()
    {
        $cadries = Cadry::filter()->where('status',true)->whereDate('created_at',now()->format('Y-m-d'))->get();
        
        return view('statistics.newcadries',[
            'cadries' => $cadries
        ]);
    }

    public function delcadries()
    {
        $cadries = DemoCadry::filter()->where('status',0)
        ->whereDate('created_at',now()->format('Y-m-d'))
        ->paginate(10);
        
        return view('statistics.delcadries',[
            'cadries' => $cadries
        ]);
    }

    
    public function birthcadries()
    {
        $cadries = Cadry::filter()
        ->where('status',true)
        ->whereMonth('birht_date', '=', now()->format('m'))
        ->whereDay('birht_date', '=', now()->format('d'))
        ->orderBy('org_order','asc')
        ->orderBy('dep_order','asc');
        
        return view('statistics.birthcadries',[
            'cadries' => $cadries->paginate(10)
        ]);
    }

    public function photoView()
    {
        return view('uty.photoview');
    }

    public function receptions() 
    {
        $receptions = Reception::with(['user.userorganization','user.userorganization.organization','resultreception'])->get();
        $recs = $receptions->toArray();
        //dd($receptions[]->resultreception[0]->rec_text);
        return view('uty.receptions',[
            'receptions' => $receptions,
            'recs' => $recs
        ]);
    }

    public function send_receptions(Request $request)
    {
        $rec = new Reception();
        $rec->user_id = Auth::user()->id;
        $rec->text_rec = $request->text_rec;
        $rec->save();

        return redirect()->back()->with('msg' , 1);
    }

    public function black_del() 
    {
        $railways = Railway::all();
        $organizations = Organization::query()->where('railway_id', request('railway_id', 0))->get();

        $cadries = DemoCadry::filter()->where('status',1);

        return view('statistics.blackdel',[
            'cadries' => $cadries->paginate(15),
            'railways' => $railways,
            'organizations' => $organizations
        ]);
    }

    public function staff_ajax()
    {
        $org_id = UserOrganization::where('user_id',Auth::user()->id)->value('organization_id');

        $options = Staff::where('organization_id',$org_id)->get();

        if (request()->ajax())  {
                $s = request()->query('s', '');
                
                $options = Staff::where('name', 'like', "%$s%")->get();
    
                return view('cadry.includes.inc_options',[
                    'options'=> $options,
                ]);
                
            }
            
        return view('cadry.includes.inc_options',[
                'options'=> $options,
        ]);
    }

    public function userDevices() 
    {
        $devices = AuthenticationLog::where('login_successful',true)->with('user')->orderBy('login_at','desc')->paginate(10);
        return view('admin.userdevices',[
            'devices'=> $devices,
    ]);
    }

    public function sessions() 
    {
        $sessions = Revision::with(['user','cadry','cadry.organization'])->orderBy('created_at','desc')->paginate(10);
        return view('admin.sessions',[
            'sessions'=> $sessions,
        ]);
    }

    public function CadryVS(Request $request) 
    {
        $x = 0; $y = 0; $sverxCount = 0; $vacanCount = 0;
        if(!request('vacan') && !request('sverx')) {

            $allStaffs = DepartmentStaff::Filter()
                ->where(function ($query) {
                    $query->whereRaw('stavka <> summ_stavka')
                    ->orWhere('summ_stavka',null);
                })->with('organization');
           
            $sverx = DepartmentStaff::Filter()
                ->whereRaw('stavka < summ_stavka');
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
            
            
        }
        
        return view('uty.CadryVS',[
            'allStaffs' => $allStaffs->paginate(10),
            'sverxCount' => $sverxCount,
            'vacanCount' => $vacanCount
        ]);
    }

    public function CadryMeds(Request $request) 
    {
            $meds = Cadry::FilterJoin()
                ->select(['cadries.*', 'medical_examinations.*'])
                ->where('cadries.status',true)
                ->where('medical_examinations.status',true)
                ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
                ->orderBy('medical_examinations.date2')
                ->whereDate('medical_examinations.date2','<=', now());
       
        return view('uty.CadryMeds',[
            'meds' => $meds->paginate(15),
        ]);
    }

    public function CadryVacations(Request $request) 
    {
       
        $cadries = Vacation::OrgFilter();
       
        return view('uty.CadryVacations',[
            'cadries' => $cadries->paginate(15),
        ]);
    }

    public function CadryCareers(Request $request) 
    {
        $cadries = Cadry::filter()->where('railway_id','!=',3)->has('careers', '=', 0)->with('organization');

        return view('uty.CadryCareers',[
            'cadries' => $cadries->paginate(15),
        ]);
    }

    public function CadryRelatives(Request $request) 
    {
     
        $cadries = Cadry::filter()->where('railway_id','!=',3)->has('relatives', '=', 0)->with('organization');
       
        return view('uty.CadryRelatives',[
            'cadries' => $cadries->paginate(15),
        ]);
    }


    public function CadryMeds_org(Request $request) 
    {
            $meds = Cadry::where('organization_id',auth()->user()->userorganization->organization_id)
                ->select(['cadries.*', 'medical_examinations.*'])
                ->where('cadries.status',true)
                ->where('medical_examinations.status',true)
                ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
                ->orderBy('medical_examinations.date2')
                ->whereDate('medical_examinations.date2','<=', now());
       
        return view('uty.CadryMeds',[
            'meds' => $meds->paginate(15),
        ]);
    }

    public function CadryNotMeds_org(Request $request) 
    {
        $meds = Cadry::where('organization_id',auth()->user()->userorganization->organization_id)
            ->where('status', true)
            ->has('med','=',0)
            ->with('organization');

        return view('uty.CadryNotMeds',[
            'meds' => $meds->paginate(15),
        ]);
    }

    public function CadryVacations_org(Request $request) 
    {
       
        $cadries = Vacation::where('organization_id',auth()->user()->userorganization->organization_id)->where('status',true)
            ->whereDate( 'date2' , '>=' ,now() )
            ->with('cadry');
       
        return view('uty.CadryVacations',[
            'cadries' => $cadries->paginate(15),
        ]);
    }

    public function CadryCareers_org(Request $request) 
    {
        $cadries = Cadry::where('organization_id',auth()->user()->userorganization->organization_id)
            ->where('status', true)
            ->has('careers', '=', 0)
            ->with('organization');

        return view('uty.CadryCareers',[
            'cadries' => $cadries->paginate(15),
        ]);
    }

    public function CadryRelatives_org(Request $request) 
    {
     
        $cadries = Cadry::where('organization_id',auth()->user()->userorganization->organization_id)
            ->where('status', true)
            ->has('relatives', '=', 0)
            ->with('organization');
        
        return view('uty.CadryRelatives',[
            'cadries' => $cadries->paginate(15),
        ]);
    }


    public function ExcelMeds(Request $request) 
    {
            $meds = Cadry::FilterJoin()
                ->select(['cadries.*', 'medical_examinations.*'])
                ->where('cadries.status',true)
                ->where('medical_examinations.status',true)
                ->join('medical_examinations', 'medical_examinations.cadry_id', '=', 'cadries.id')
                ->orderBy('medical_examinations.date2')
                ->whereDate('medical_examinations.date2','<=', now())->get();
       
            return Excel::download(new CareerExport($meds), 'exodim.xlsx');
    }
    public function ExcelNotMeds(Request $request) 
    {
        $meds = Cadry::filter()->where('railway_id','!=',3)
        ->has('med','=',0)
        ->with('organization')->get();
       
         return Excel::download(new CareerExport($meds), 'exodim.xlsx');
    }

    public function ExcelCareers(Request $request) 
    {
        $cadries = Cadry::filter()->where('railway_id','!=',3)->has('careers', '=', 0)->with('organization')->get();

        return Excel::download(new CareerExport($cadries), 'exodim.xlsx');
    }

    public function ExcelRelatives(Request $request) 
    {
     
        $cadries = Cadry::filter()->where('railway_id','!=',3)->has('relatives', '=', 0)->with('organization')->get();
       
        return Excel::download(new RelativeExport($cadries), 'exodim.xlsx');
    }
}
