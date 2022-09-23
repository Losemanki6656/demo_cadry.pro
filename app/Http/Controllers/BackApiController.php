<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\DemoCadry;
use App\Models\AcademicTitle;
use App\Models\AcademicDegree;
use App\Models\Nationality;
use App\Models\Party;
use App\Models\WorkLevel;
use App\Models\Relative;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Incentive;
use App\Models\UserOrganization;
use App\Models\Railway;
use App\Models\Vacation;
use App\Models\Staff;
use App\Models\StaffFile;
use App\Models\DeleteCadry;
use App\Models\User;
use App\Models\Career;
use App\Models\Turnicet;
use App\Models\Region;
use App\Models\Reception;
use App\Models\Language;
use App\Models\CadryRelative;
use App\Models\DisciplinaryAction;
use App\Models\AuthenticationLog;
use App\Models\MedicalExamination;
use App\Models\InfoEducation;
use App\Models\Revision;
use App\Models\Education;
use App\Models\DepartmentCadry;
use App\Models\AbroadStudy;
use App\Models\AcademiStudy;
use App\Models\Abroad;
use App\Models\AcademicName;
use App\Models\DepartmentStaff;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RailwayResource;
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
use App\Http\Resources\CadryEditResource;
use App\Http\Resources\AcademicTitleResource;
use App\Http\Resources\AcademiceDegreeResource;
use App\Http\Resources\CadryInfoResource;
use App\Http\Resources\CadryRelativeResource;
use App\Http\Resources\DisciplinaryActionResource;
use App\Http\Resources\IncentiveResource;
use App\Http\Resources\StaffFileResource;
use App\Http\Resources\AbroadStudyResource;
use App\Http\Resources\AcademicStudyResource;
use App\Http\Resources\AbroadResource;
use App\Http\Resources\AcademicResource;
use App\Http\Resources\MedicalResource;
use App\Http\Resources\DepartmentStaffResource;

class BackApiController extends Controller
{
    
    public function api_permissions()
    {
        
    }

    public function api_cadry_edit($id)
    {
        $cadry = Cadry::with(['allStaffs.department','work_level'])->find($id);

        return response()->json([
            'cadry' => new CadryEditResource($cadry),
        ]);
    }

    public function api_cadry_information($id)
    {
        $cadry = Cadry::with(['work_level'])->find($id);

        return response()->json([
            'cadry' => new CadryInfoResource($cadry),
        ]);
    }

    public function api_cadry_information_post(Request $request, Cadry $cadry)
    {       
        $cadry->update($request->all());

        $fullname = $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name;
        return response()->json([
            'message' => $fullname . " ma'lumotlari muvaffaqqiyatli taxrirlandi !"
        ]);
    }

    public function api_cadry_edit_post(Request $request, Cadry $cadry)
    {       
        $cadry->update($request->all());
        $fullname = $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name;
        return response()->json([
            'message' => $fullname . " ma'lumotlari muvaffaqqiyatli taxrirlandi !"
        ]);
    }

    public function api_cadry_update_photo_post(Request $request, Cadry $cadry)
    {
        $cadry->update($request->all());
        $fullname = $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name;

        return response()->json([
            'message' => $fullname . " ma'lumotlari muvaffaqqiyatli taxrirlandi !"
        ]);

    }

    public function api_cadry_institut(Request $request)
    {
        $infoeducations = InfoEducation::where('cadry_id',$request->cadry_id)->get();

        return response()->json([
            'infoeducations' =>  InfoEducationResource::collection($infoeducations),
        ]);
    }

    public function api_cadry_institut_add($cadry, Request $request)
    {
        if(Cadry::find($cadry)->organization_id != auth()->user()->userorganization->organization_id)
        return response()->json([
            'error' => "Xodim topilmadi!"
        ],404);

        $neweducation = new InfoEducation();
        $neweducation->cadry_id = $cadry;
        $neweducation->sort = 0;
        $neweducation->date1 = $request->date1 ?? '';
        $neweducation->date2 = $request->date2 ?? '';
        $neweducation->institut = $request->institut ?? '';
        $neweducation->speciality = $request->speciality ?? '';
        $neweducation->save();

        return response()->json([
            'message' => "Muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function api_cadry_institut_update(InfoEducation $infoeducation_id , Request $request)
    {
        $infoeducation_id->date1 = $request->date1 ?? '';
        $infoeducation_id->date2 = $request->date2 ?? '';
        $infoeducation_id->institut = $request->institut ?? '';
        $infoeducation_id->speciality = $request->speciality ?? '';
        $infoeducation_id->save();
        
        return response()->json([
            'message' => "Muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function api_cadry_institut_delete(InfoEducation $infoeducation_id)
    {
        $infoeducation_id->delete();

        return response()->json([
            'message' => "Muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function cadry_api_careers($id)
    {
        $careers = Career::where('cadry_id', $id)
            ->orderBy('sort','asc')->get();

        return response()->json([
            'careers' => CareerResource::collection($careers)
        ]);
    }

    
    public function cadry_api_career_add($cadry_id, Request $request)
    {
        $count = Career::where('cadry_id', $cadry_id)->count();

        $newscareer = new Career();
        $newscareer->cadry_id = $cadry_id;
        $newscareer->sort = $count + 1;
        $newscareer->date1 = $request->date1 ?? '';
        $newscareer->date2 = $request->date2 ?? '';
        $newscareer->staff = $request->staff ?? '';
        $newscareer->save();

        return response()->json([
            'message' => "Mehnat faoliyati malumotlari muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function cadry_api_career_update($career_id, Request $request)
    {
        $newscareer = Career::find($career_id);
        $newscareer->date1 = $request->date1 ?? '';
        $newscareer->date2 = $request->date2 ?? '';
        $newscareer->staff = $request->staff ?? '';
        $newscareer->save();

        return response()->json([
            'message' => "Mehnat faoliyati malumotlari muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function cadry_api_career_delete(Career $career_id)
    {
        $career_id->delete();

        return response()->json([
            'message' => "Mehnat faoliyati malumotlari muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function api_career_sortable(Request $request)
    {
        if(!$request->orders) return response()->json([
            'error' => 'orders empty elements'
        ]); else

        foreach ($request->orders as $item) {
            Career::find($item['career_id'])->update(['sort' => $item['position']]);      
        }

        return response()->json([
            'message' => 'Tartiblash muvaffaqqiyatli amalga oshirildi!'
        ]);   
    }

    public function cadry_api_relatives($cadry_id)
    {
        if(Cadry::find($cadry_id)->organization_id != auth()->user()->userorganization->organization_id)
        return response()->json([
            'error' => "Xodim topilmadi!"
        ],404);

        $relatives = Relative::all();
        $cadryrelatives = CadryRelative::where('cadry_id',$cadry_id)
            ->orderBy('sort','asc')
            ->with('relative')->get();

        return response()->json([
            'relatives' => CadryRelativeResource::collection($relatives),
            'cadryRelatives' => RelativesResource::collection($cadryrelatives)
        ]);
    }

    public function api_add_relative_cadry($cadry_id, Request $request)
    {
        $count = CadryRelative::where('cadry_id', $cadry_id)->count();

        $newerelative = new CadryRelative();
        $newerelative->cadry_id = $cadry_id;
        $newerelative->relative_id = $request->relative_id;
        $newerelative->sort = $count + 1;
        $newerelative->fullname = $request->fullname ?? '';
        $newerelative->birth_place = $request->birth_place ?? '';
        $newerelative->post = $request->post ?? '';
        $newerelative->address = $request->address ?? '';
        $newerelative->save();

        return response()->json([
            'message' => "Yaqin qarindosh malumotlari muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function api_update_relative_cadry($cadry_relative_id, Request $request)
    {

        $newerelative = CadryRelative::find($cadry_relative_id);
        $newerelative->relative_id = $request->relative_id;
        $newerelative->fullname = $request->fullname ?? '';
        $newerelative->birth_place = $request->birth_place ?? '';
        $newerelative->post = $request->post ?? '';
        $newerelative->address = $request->address ?? '';
        $newerelative->save();

        return response()->json([
            'message' => "Yaqin qarindosh malumotlari muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function api_delete_relative_cadry(CadryRelative $cadry_relative_id)
    {
       $cadry_relative_id->delete();

        return response()->json([
            'message' => "Yaqin qarindosh malumotlari muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function api_relatives_sortable(Request $request)
    {
        if(!$request->orders) return response()->json([
            'error' => 'orders empty elements'
        ]); else

        foreach ($request->orders as $item) {
            CadryRelative::find($item['cadry_relative_id'])->update(['sort' => $item['position']]);      
        }

        return response()->json([
            'message' => 'Tartiblash muvaffaqqiyatli amalga oshirildi!'
        ]);   
    }

    public function api_add_discip_cadry($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'date_punishment' => ['required', 'date']
         ]);
      
        $dis = new DisciplinaryAction();
        $dis->cadry_id = $cadry_id;
        $dis->number = $request->command_number ?? '';
        $dis->date_action = $request->date_punishment;
        $dis->type_action = $request->type_punishment ?? '';
        $dis->reason_action = $request->reason_punishmend ?? '';
        $dis->save();

        return response()->json([
            'message' => "Intizomiy jazo qo'shish muvaffaqqiyatli amalga oshirildi!"
        ]);   
    }

    public function cadry_api_punishments($cadry_id)
    {
        if(Cadry::find($cadry_id)->organization_id != auth()->user()->userorganization->organization_id)
        return response()->json([
            'error' => "Xodim topilmadi!"
        ],404);

        $punishments = DisciplinaryAction::where('cadry_id',$cadry_id)->get();

        return response()->json([
            'punishments' => DisciplinaryActionResource::collection($punishments)
        ]);
    }

    public function api_update_discip_cadry($punishment_id, Request $request)
    {
        $validated = $request->validate([
            'date_punishment' => ['required', 'date']
         ]);
      
        $dis = DisciplinaryAction::find($punishment_id);
        $dis->number = $request->command_number ?? '';
        $dis->date_action = $request->date_punishment;
        $dis->type_action = $request->type_punishment ?? '';
        $dis->reason_action = $request->reason_punishmend ?? '';
        $dis->save();

        return response()->json([
            'message' => "Intizomiy jazo muvaffaqqiyatli taxrirlandi!"
        ]);   
    }

    public function api_delete_discip_cadry(DisciplinaryAction $punishment_id)
    {
        $punishment_id->delete();

        return response()->json([
            'message' => "Intizomiy jazo muvaffaqqiyatli o'chirildi!"
        ]);   
    }

     
    public function api_add_incentive_cadry($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'incentive_date' => ['required', 'date']
         ]);

        $incentive = new Incentive();
        $incentive->cadry_id = $cadry_id;
        $incentive->by_whom = $request->by_whom ?? '';
        $incentive->number = $request->command_number ?? '';
        $incentive->incentive_date = $request->incentive_date;
        $incentive->type_action = $request->type_incentive ?? '';
        $incentive->type_reason = $request->reason_incentive ?? '';
        $incentive->status = $request->status;
        $incentive->save();

        return response()->json([
            'message' => "Rag'batlantirish muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function api_update_incentive_cadry($incentive_id, Request $request)
    {
        $validated = $request->validate([
            'incentive_date' => ['required', 'date']
         ]);

        $incentive = Incentive::find($incentive_id);
        $incentive->by_whom = $request->by_whom ?? '';
        $incentive->number = $request->command_number ?? '';
        $incentive->incentive_date = $request->incentive_date;
        $incentive->type_action = $request->type_incentive ?? '';
        $incentive->type_reason = $request->reason_incentive ?? '';
        $incentive->status = $request->status;
        $incentive->save();

        return response()->json([
            'message' => "Rag'batlantirish muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function api_delete_incentive_cadry(Incentive $incentive_id)
    {
        $incentive_id->delete();

        return response()->json([
            'message' => "Rag'batlantirish muvaffaqqiyatli o'chirildi!"
        ]);
    }
   
    public function api_cadry_incentives($cadry_id)
    {
        $incentives = Incentive::where('cadry_id',$cadry_id)->get();

        return response()->json([
            'incentives' => IncentiveResource::collection($incentives)
        ]);
    }

    public function api_cadry_stafffiles($cadry_id)
    {
        $incentives = StaffFile::where('cadry_id',$cadry_id)->get();

        return response()->json([
            'staff_files' => StaffFileResource::collection($incentives)
        ]);
    }

    public function api_add_stafffiles_cadry($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'file_staff' => ['required', 'file']
         ]);

        $fileName = time().'.'.$request->file_staff->extension();

        $path = $request->file_staff->storeAs('stafffiles', $fileName);

        $newfile = new StaffFile();
        $newfile->cadry_id = $cadry_id;
        $newfile->comment = $request->comment ?? '';
        $newfile->file_path = 'storage/' . $path;
        $newfile->save();

        return response()->json([
            'message' => "Lavozim yo'riqnomasi muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function api_update_stafffiles_cadry($staff_file_id, Request $request)
    {
       if($request->file_staff) {
            $validated = $request->validate([
                'file_staff' => ['required', 'file']
            ]);

            $fileName = time().'.'.$request->file_staff->extension();

            $path = $request->file_staff->storeAs('stafffiles', $fileName);
       }

        $newfile = StaffFile::find($staff_file_id);
        $newfile->comment = 'asd';
        if($request->file_staff) 
        $newfile->file_path = 'storage/' . $path;
        $newfile->save();

        return response()->json([
            'message' => "Lavozim yo'riqnomasi muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function api_delete_stafffiles_cadry(StaffFile $staff_file_id, Request $request)
    {
        $staff_file_id->delete();

        return response()->json([
            'message' => "Lavozim yo'riqnomasi muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function cadry_api_abroadStudies($cadry_id)
    {   
        $data = AbroadStudyResource::collection(AbroadStudy::where('cadry_id',$cadry_id)->get());

        return response()->json($data);
    }

    public function cadry_api_academicStudies($cadry_id)
    {   
        $data = AcademicStudyResource::collection(AcademiStudy::where('cadry_id',$cadry_id)->get());

        return response()->json($data);
    }

    public function cadry_api_abroadStudies_add($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'date1' => ['required'],
            'date2' => ['required'],
            'abroad_id' => ['required']
         ]);

        $new = new AbroadStudy();
        $new->cadry_id = $cadry_id;
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute ?? '';
        $new->direction = $request->direction ?? '';
        $new->type_abroad = $request->abroad_id;
        $new->save();

        return response()->json([
            'message' => "Ta'lim muassasasi muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function cadry_api_abroadStudies_update($abroad_study_id, Request $request)
    {
        $validated = $request->validate([
            'date1' => ['required'],
            'date2' => ['required'],
            'abroad_id' => ['required']
         ]);

        $new = AbroadStudy::find($abroad_study_id);
        $new->date1 = $request->date1;
        $new->date2 = $request->date2;
        $new->institute = $request->institute ?? '';
        $new->direction = $request->direction ?? '';
        $new->type_abroad = $request->abroad_id;
        $new->save();

        return response()->json([
            'message' => "Ta'lim muassasasi muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function cadry_api_abroadStudies_delete(AbroadStudy $abroad_study_id)
    {
        $abroad_study_id->delete();

        return response()->json([
            'message' => "Ta'lim muassasasi muvaffaqqiyatli o'chrildi!"
        ]);
    }

    public function cadry_api_academicStudies_add($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'date1' => ['required'],
            'date2' => ['required'],
            'academic_id' => ['required']
         ]);

         $new = new AcademiStudy();
         $new->cadry_id = $cadry_id;
         $new->date1 = $request->date1;
         $new->date2 = $request->date2;
         $new->institute = $request->academic_id;
         $new->save();
 

        return response()->json([
            'message' => "Akademiya muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function cadry_api_academicStudies_update($academic_study_id, Request $request)
    {
        $validated = $request->validate([
            'date1' => ['required'],
            'date2' => ['required'],
            'academic_id' => ['required']
         ]);

         $new = AcademiStudy::find($academic_study_id);
         $new->date1 = $request->date1;
         $new->date2 = $request->date2;
         $new->institute = $request->academic_id;
         $new->save();
 

        return response()->json([
            'message' => "Akademiya muvaffaqqiyatli yangilandi!"
        ]);
    }

    public function cadry_api_academicStudies_delete(AcademiStudy $academic_study_id)
    {
        $academic_study_id->delete();

        return response()->json([
            'message' => "Akademiya muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function api_cadry_meds($cadry_id)
    {
        $meds = MedicalExamination::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'meds' => MedicalResource::collection($meds)
        ]);
    }

    public function api_cadry_meds_delete(MedicalExamination $med_id)
    {
        $med_id->delete();

        return response()->json([
            'message' => "Tibbiy ko'rik ma'lumotlari muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function api_add_worker(Request $request)
    {
        $validated = $request->validate([
            'last_name' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'birth_region_id' => ['required'],
            'birth_city_id' => ['required'],
            'address_region_id' => ['required'],
            'address_city_id' => ['required'],
            'address' => ['required'],
            'pass_region_id' => ['required'],
            'pass_city_id' => ['required'],
            'jshshir' => ['required','min:14','unique'],
            'job_date' => ['required','date'],
            'department_id' => ['required'],
            'staff_id' => ['required'],
            'post_date' => ['required','date'],
            'education_id' => ['required'],
            'academictitle_id' => ['required'],
            'academicdegree_id' => ['required'],
            'nationality_id' => ['required'],
            'language' => ['required'],
            'worklevel_id' => ['required'],
            'party_id' => ['required'],
            'military_rank' => ['required'],
            'deputy' => ['required'],
            'phone' => ['required'],
         ]);

        $validator3 = DemoCadry::where('status',true)->where('jshshir',$request->jshshir)->get();
        $validator = Cadry::where('status',true)->where('jshshir',$request->jshshir)->with('organization')->get();
        $validator2 = Cadry::where('status',false)->where('jshshir',$request->jshshir)->with('organization')->get();

        if(count($validator3) > 0)
        {
            return response()->json([
                'status' => false, 
                'message' => "Ushbu xodim qora ro'yxatga kiritilgan"
            ], 422);

        } else
        if ( count($validator) > 0 ) {

            return response()->json([
                'status' => false, 
                'message' => "Xodim ". $validator[0]->last_name . ' ' . $validator[0]->first_name . ' ' . $validator[0]->middle_name . $validator[0]->organization->name . " korxonasida ishlaydi"
            ], 422);

        } else if(count($validator2) > 0) {
            
            return response()->json([
                'status' => false, 
                'message' => "Ushbu xodim qora arxivda mavjud"
            ], 422);

        } else {

            $dep = DepartmentStaff::with('cadry')->find($request->staff_id);
            $organ = auth()->user()->userorganization;

            $array = $request->all();
            $array['railway_id'] = $organ->railway_id;
            $array['organization_id'] = $organ->organization_id;
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

            if($dep->stavka < $dep->cadry->sum('stavka') +  $request->stavka) 
                $newItem->status_sv = true; 
            else
                $newItem->status_sv = false;
                $newItem->cadry_id = $cadry->id;
                $newItem->stavka = $request->stavka;
                $newItem->save();
        
            return response()->json([
                'status' => true,
                'message' => "Xodim muvaffaqqiyatli qo'shildi!"
            ]);;
        }

       
    }

    public function apiStaffCadryEdit($id)
    {
        $item =  DepartmentCadry::find($id);

        $staffs = DepartmentStaff::where('department_id', $item->department_id)->get();

        return response()->json([
            'department_id' => $item->department_id,
            'rate' => $item->stavka,
            'staff_status' => $item->staff_status,
            'staff_statuts' => [
                [
                    'id' => 0,
                    'name' => "Asosiy"
                ],
                [
                    'id' => 1,
                    'name' => "O'rindosh"
                ]
                ],
            'staff_date' => $item->staff_date,
            'departments' => DepResource::collection(Department::where('organization_id',auth()->user()->userorganization->organization_id)->get()),
            'department_staffs' => DepartmentStaffResource::collection(DepartmentStaff::where('department_id', $item->department_id)->get())
        ]);
    }

    public function careerCheck(Request $request)
    {
        $data = [];
        if ($request->has('cadry_id')) {
            $id = $request->cadry_id;
            $data = Career::where('cadry_id', $id )->orderBy('id', 'desc')->get();
        }
        return response()->json($data);
    }

    public function api_check_pinfl(Request $request)
    {
        $validator3 = DemoCadry::where('status',true)->where('jshshir',$request->pinfl)->get();
        $validator = Cadry::where('status',true)->where('jshshir',$request->pinfl)->with('organization')->get();
        $validator2 = Cadry::where('status',false)->where('jshshir',$request->pinfl)->with('organization')->get();

        if(count($validator3) > 0)
        {
            return response()->json([
                'status' => false, 
                'message' => "Ushbu xodim qora ro'yxatga kiritilgan"
            ], 422);

        } else
        if ( count($validator) > 0 ) {

            return response()->json([
                'status' => false, 
                'message' => "Xodim ". $validator[0]->last_name . ' ' . $validator[0]->first_name . ' ' . $validator[0]->middle_name . $validator[0]->organization->name . " korxonasida ishlaydi"
            ], 422);

        } else if(count($validator2) > 0) {
            
            return response()->json([
                'status' => false, 
                'message' => "Ushbu xodim qora arxivda mavjud"
            ], 422);

        } else 

        return response()->json([
            'status' => true, 
            'message' => "Xodim topilmadi"
        ]);

    }

    public function api_department_cadry_update($department_cadry_id, Request $request)
    {

        $newItem = DepartmentCadry::find($department_cadry_id);
        $editstaff = DepartmentStaff::with('cadry')->find($request->staff_id);

        $newItem->department_id = $request->department_id;
        $newItem->department_staff_id = $request->staff_id;
        $newItem->staff_id = $editstaff->staff_id;
        $newItem->staff_full = $editstaff->staff_full;
        $newItem->staff_status = $request->staff_status;
                $newItem->staff_date = $request->staff_date;

                if($editstaff->stavka <= $editstaff->cadry->sum('stavka') + $request->st_1) 
                    $newItem->status_sv = true; 
                else
                    $newItem->status_sv = false;

                $newItem->stavka = $request->rate;
                $newItem->save();

                if($request->staff_status == 0) {
                    $cadry = Cadry::find($newItem->cadry_id);
                    $cadry->department_id = $request->department_id;
                    $cadry->staff_id = $editstaff->staff_id;
                    $cadry->post_name = $editstaff->staff_full;
                    $cadry->save();
                }

                if($request->careerCheck == 'on') {
                    $careerItem = Career::find($request->career_id);
                    $careerItem->date2 = date("Y", strtotime($request->staff_date));
                    $careerItem->save();

                    $itC = new Career();
                    $itC->cadry_id = $newItem->cadry_id;
                    $itC->sort = $careerItem->sort + 1;
                    $itC->date1 =  date("Y", strtotime($request->staff_date));
                    $itC->date2 = '';
                    $itC->staff = $editstaff->staff_full;
                    $itC->save();

                }

        return response()->json([
            'status' => true,
            'message' => "Xodim lavozimi muvaffaqqiyatli o'zgartirildi!"
        ]);
    }

    public function SuccessDeleteCadryStaff($department_cadry_id, Request $request)
    {
        $item =  DepartmentCadry::with('cadry')->find($department_cadry_id);
        
        $newDelCadry = new DeleteCadry();
        $newDelCadry->railway_id = $item->railway_id;
        $newDelCadry->organization_id = $item->organization_id;
        $newDelCadry->department_id = $item->department_id;
        $newDelCadry->cadry_id = $item->cadry_id;
        $newDelCadry->number = $request->command_number;
        $newDelCadry->comment = $request->comment;
        $newDelCadry->staff_full = $item->staff_full;
        $newDelCadry->date = $request->date;
        $newDelCadry->save();

        $car = Career::find($request->career_id);
        $car->date2 = date("Y", strtotime($request->date));
        $car->save();

        $item->delete();
        
        return response()->json([
            'status' => true,
            'message' => "Xodim lavozimi muvaffaqqiyatli yakunlandi!"
        ]);

    }

}
