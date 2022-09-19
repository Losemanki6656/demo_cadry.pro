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

}
