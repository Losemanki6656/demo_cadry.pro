<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\DemoCadry;
use App\Models\Passport;
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
use App\Models\CadryCreate;
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
use App\Http\Resources\ExcelOrgResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\StaffResource;
use App\Http\Resources\PassportResource;
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
use App\Http\Resources\CadryStaffResource;

class BackApiController extends Controller
{

    public function api_permissions()
    {
    }

    public function api_cadry_edit($id)
    {
        $user = auth()->user()->userorganization;
        $cadry = Cadry::with(['allStaffs.department', 'work_level'])->find($id);

        if(auth()->user()->can('cadry_leader_cadries')) {
            if($cadry->railway_id == $user->railway_id) {
                return response()->json([
                    'cadry' => new CadryEditResource($cadry),
                ]);
            } else {
                return response()->json([
                    'message' => "Ma'lumot topilmadi",
                ], 404);
            }
        } else {
            if($cadry->organization_id == $user->organization_id) {
                return response()->json([
                    'cadry' => new CadryEditResource($cadry),
                ]);
            } else {
                return response()->json([
                    'message' => "Ma'lumot topilmadi",
                ], 404);
            }
        }
        
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
        $validator3 = DemoCadry::where('status', true)
            ->where('jshshir', $request->jshshir)
            ->get();
        $validator = Cadry::where('status', true)
            ->where('jshshir', $request->jshshir)
            ->with('organization')->first();

        $validator2 = Cadry::where('status', false)
            ->where('jshshir', $request->jshshir)
            ->with('organization')->get();

        if (count($validator3) > 0) {
            return response()->json([
                'status' => 3,
                'message' => "Ushbu xodim qora ro'yxatga kiritilgan"
            ], 400);
        } else
        if ($validator && $validator->id != $cadry->id) {
            return response()->json([
                'status' => 1,
                'fullname' => $validator->last_name . ' ' . $validator->first_name . ' ' . $validator->middle_name,
                'organization' => $validator->organization->name
            ], 400);
        } else if (count($validator2) > 0) {

            return response()->json([
                'status' => 2,
                'message' => "Ushbu xodim arxivda mavjud"
            ], 400);
        } 
          else 
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
        $infoeducations = InfoEducation::where('cadry_id', $request->cadry_id)->get();

        return response()->json([
            'infoeducations' =>  InfoEducationResource::collection($infoeducations),
        ]);
    }

    public function api_cadry_institut_add($cadry, Request $request)
    {
        if (Cadry::find($cadry)->organization_id != auth()->user()->userorganization->organization_id)
            return response()->json([
                'error' => "Xodim topilmadi!"
            ], 404);

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

    public function api_cadry_institut_update(InfoEducation $infoeducation_id, Request $request)
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
            ->orderBy('sort', 'asc')->get();

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
        if (!$request->orders) return response()->json([
            'error' => 'orders empty elements'
        ]);
        else

            foreach ($request->orders as $item) {
                Career::find($item['career_id'])->update(['sort' => $item['position']]);
            }

        return response()->json([
            'message' => 'Tartiblash muvaffaqqiyatli amalga oshirildi!'
        ]);
    }

    public function cadry_api_relatives($cadry_id)
    {
        
        if (Cadry::find($cadry_id)->organization_id != auth()->user()->userorganization->organization_id)
            return response()->json([
                'error' => "Xodim topilmadi!"
            ], 404);

        $relatives = Relative::all();
        $cadryrelatives = CadryRelative::where('cadry_id', $cadry_id)
            ->orderBy('sort', 'asc')
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
        if (!$request->orders) return response()->json([
            'error' => 'orders empty elements'
        ]);
        else

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
        if (Cadry::find($cadry_id)->organization_id != auth()->user()->userorganization->organization_id)
            return response()->json([
                'error' => "Xodim topilmadi!"
            ], 404);

        $punishments = DisciplinaryAction::where('cadry_id', $cadry_id)->get();

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
        $incentives = Incentive::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'incentives' => IncentiveResource::collection($incentives)
        ]);
    }

    public function api_cadry_stafffiles($cadry_id)
    {
        $incentives = StaffFile::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'staff_files' => StaffFileResource::collection($incentives)
        ]);
    }

    public function api_add_stafffiles_cadry($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'file_staff' => ['required', 'file']
        ]);

        $fileName = time() . '.' . $request->file_staff->extension();

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
        if ($request->file_staff) {
            $validated = $request->validate([
                'file_staff' => ['required', 'file']
            ]);

            $fileName = time() . '.' . $request->file_staff->extension();

            $path = $request->file_staff->storeAs('stafffiles', $fileName);
        }

        $newfile = StaffFile::find($staff_file_id);
        $newfile->comment = 'asd';
        if ($request->file_staff)
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
        $data = AbroadStudyResource::collection(AbroadStudy::where('cadry_id', $cadry_id)->get());

        return response()->json($data);
    }

    public function cadry_api_academicStudies($cadry_id)
    {
        $data = AcademicStudyResource::collection(AcademiStudy::where('cadry_id', $cadry_id)->get());

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
            'jshshir' => ['required', 'min:14'],
            'job_date' => ['required', 'date'],
            'department_id' => ['required'],
            'staff_id' => ['required'],
            'post_date' => ['required', 'date'],
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

        $validator3 = DemoCadry::where('status', true)->where('jshshir', $request->jshshir)->get();
        $validator = Cadry::where('status', true)->where('jshshir', $request->jshshir)->with('organization')->get();
        $validator2 = Cadry::where('status', false)->where('jshshir', $request->jshshir)->with('organization')->get();

        if (count($validator3) > 0) {
            return response()->json([
                'status' => 3,
                'message' => "Ushbu xodim qora ro'yxatga kiritilgan"
            ], 200);
        } else
        if (count($validator) > 0) {

            return response()->json([
                'status' => 1,
                'fullname' => $validator[0]->last_name . ' ' . $validator[0]->first_name . ' ' . $validator[0]->middle_name,
                'organization' => $validator[0]->organization->name
            ], 200);
        } else if (count($validator2) > 0) {

            return response()->json([
                'status' => 2,
                'message' => "Ushbu xodim arxivda mavjud"
            ], 200);
        } else {

            $dep = DepartmentStaff::with('cadry')->find($request->staff_id);
            $organ = auth()->user()->userorganization;

            $array = $request->all();
            $array['railway_id'] = $organ->railway_id;
            $array['organization_id'] = $organ->organization_id;
            $array['post_name'] = $dep->staff_full;
            $array['staff_id'] = $dep->staff_id;
            $array['middle_name'] = $request->middle_name ?? '';

            if($request->order == null) 
                $array['order'] = 0; else $array['order'] = $request->order;
            $array['status_dec'] = $request->status_dec ?? 0;

            
            if($request->inostrans) 
                $array['date_inostrans'] = $request->date_inostrans; else $array['date_inostrans'] = now()->format('Y-m-d');
            
            $cadry = Cadry::create($array);

            $newItem = new DepartmentCadry();
            $newItem->railway_id = $array['railway_id'];
            $newItem->organization_id = $array['organization_id'];
            $newItem->department_id = $request->department_id;
            $newItem->department_staff_id = $request->staff_id;
            $newItem->staff_id = $dep->staff_id;
            $newItem->staff_full = $dep->staff_full;
            $newItem->staff_date = $request->post_date;

            if ($dep->stavka < $dep->cadry->sum('stavka') +  $request->stavka)
                $newItem->status_sv = true;
            else
                $newItem->status_sv = false;
            $newItem->cadry_id = $cadry->id;
            $newItem->stavka = $request->stavka;
            $newItem->save();

            $cadryCreate = new CadryCreate();
            $cadryCreate->railway_id = $organ->railway_id;
            $cadryCreate->organization_id = $organ->organization_id;
            $cadryCreate->cadry_id = $cadry->id;
            $cadryCreate->command_number = $request->command_number;
            $cadryCreate->comment = $request->comment;
            $cadryCreate->save();

            return response()->json([
                'status' => 4,
                'message' => "Xodim muvaffaqqiyatli qo'shildi!"
            ]);;
        }
    }

    public function full_delete_cadry(Request $request, $cadry_id)
    {
        $cadry = Cadry::find($cadry_id);
        $cadry->status = false;
        $cadry->save();

        DepartmentCadry::where('cadry_id', $cadry_id)->delete();

        $arr = Cadry::find($cadry_id)->toArray();
        $arr['number'] = $request->command_number ?? '';
        $arr['comment'] = $request->comment ?? '';
        $arr['cadry_id'] = $cadry_id;

        if ($request->blackStatus == true)
            $arr['status'] = true;

        DemoCadry::create($arr);

        return response()->json([
            'status' => true,
            'message' => "Xodim mehnat faoliyati to'laqonli yakunlandi!"
        ]);
    }

    public function apiNewStaffToCadry($cadry_id)
    {

        $items =  DepartmentCadry::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'staffs' => CadryStaffResource::collection($items),
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
            'departments' => DepResource::collection(Department::where('organization_id', auth()->user()->userorganization->organization_id)->get()),
        ]);
    }
    public function apiNewStaffToCadryPost($cadry_id, Request $request)
    {
        $newI = DepartmentCadry::where('cadry_id', $cadry_id)->first();

        $editstaff = DepartmentStaff::with('cadry')->find($request->staff_id);

        $newItem = new DepartmentCadry();
        $newItem->railway_id = $newI->railway_id;
        $newItem->organization_id = $newI->organization_id;
        $newItem->department_id = $request->department_id;
        $newItem->department_staff_id = $request->staff_id;
        $newItem->staff_id = $editstaff->staff_id;
        $newItem->staff_full = $editstaff->staff_full;
        $newItem->staff_status = $request->staff_status;
        $newItem->staff_date = $request->staff_date;

        if ($editstaff->stavka <= $editstaff->cadry->sum('stavka') + $request->st_1)
            $newItem->status_sv = true;
        else
            $newItem->status_sv = false;
        $newItem->cadry_id = $cadry_id;
        $newItem->stavka = $request->rate;

        if ($request->status_for_decret == true) {
            $newItem->status = true;
        } else $newItem->status = false;
        if ($request->status_decret == true) {
            $newItem->status_decret = true;
        } else $newItem->status_decret = false;

        $newItem->command_number = $request->command_number;
        $newItem->save();

        if ($request->staff_status == 0) {
            $cadry = Cadry::find($cadry_id);
            $cadry->department_id = $request->department_id;
            $cadry->staff_id = $editstaff->staff_id;
            $cadry->post_name = $editstaff->staff_full;
            $cadry->save();
        }

        $cadryCreate = new CadryCreate();
        $cadryCreate->railway_id = $newI->railway_id;
        $cadryCreate->organization_id = $newI->organization_id;
        $cadryCreate->cadry_id = $cadry_id;
        $cadryCreate->command_number = $request->command_number;
        $cadryCreate->update_staff = true;
        $cadryCreate->save();



        if ($request->careerCheck == true) {
            $x = Career::where('cadry_id',$cadry_id)->count();

            $itC = new Career();
            $itC->cadry_id = $cadry_id;
            $itC->sort = $x + 1;
            $itC->date1 = date("Y", strtotime($request->staff_date));
            $itC->date2 = '';
            $itC->staff = $editstaff->staff_full;
            $itC->save();
        }

        return response()->json([
            'status' => true,
            'message' => "Xodim lavozimi muvaffaqqiyatli yangilandi!"
        ]);
    }


    public function apiStaffCadryEdit($id)
    {
        $item =  DepartmentCadry::with('department')->find($id);
        $staff = DepartmentStaff::find($item->department_staff_id);
        $staffs = DepartmentStaff::where('department_id', $item->department_id)->get();

        if ($item->staff_status == 0) {
            $staff_status =  [
                'id' => 0,
                'name' => "Asosiy"
            ];
        } else  $staff_status =  [
            'id' => 1,
            'name' => "O'rindosh"
        ];

        return response()->json([
            'department_id' => new DepResource($item->department),
            'staff_id' => [
                'id' => $staff->id,
                'staff_fullname' => $staff->staff_full
            ],
            'rate' => $item->stavka,
            'staff_status' => $staff_status,
            'status_sverx' => $item->status_sv,
            'status_for_decret' => $item->status,
            'status_decret' => $item->status_decret,
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
            'departments' => DepResource::collection(Department::where('organization_id', auth()->user()->userorganization->organization_id)->get()),
            'department_staffs' => DepartmentStaffResource::collection(DepartmentStaff::where('department_id', $item->department_id)->get())
        ]);
    }

    public function careerCheck(Request $request)
    {
        $data = [];
        if ($request->has('cadry_id')) {
            $id = $request->cadry_id;
            $data = Career::where('cadry_id', $id)->orderBy('id', 'desc')->get();
        }
        return response()->json($data);
    }

    public function api_check_pinfl(Request $request)
    {
        $validator3 = DemoCadry::where('status', true)->where('jshshir', $request->pinfl)->with('organization')->get();
        $validator = Cadry::where('status', true)->where('jshshir', $request->pinfl)->with('organization')->get();
        $validator2 = Cadry::where('status', false)->where('jshshir', $request->pinfl)->with('organization')->get();

        if (count($validator3) > 0) {
            return response()->json([
                'status' => 3,
                'message' => "Ushbu xodim qora ro'yxatga kiritilgan"
            ], 200);
        } else
        if (count($validator) > 0) {

            return response()->json([
                'status' => 1,
                'fullname' => $validator[0]->last_name . ' ' . $validator[0]->first_name . ' ' . $validator[0]->middle_name,
                'organization' => $validator[0]->organization->name
            ], 200);
        } else if (count($validator2) > 0) {

            return response()->json([
                'status' => 2,
                'message' => "Ushbu xodim arxivda mavjud"
            ], 200);
        } else

            return response()->json([
                'status' => 4,
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

        if ($editstaff->stavka <= $editstaff->cadry->sum('stavka') + $request->st_1)
            $newItem->status_sv = true;
        else
            $newItem->status_sv = false;

        $newItem->stavka = $request->rate;

        if ($request->status_sverx == true) {
            $newItem->status_sv = true;
        } else $newItem->status_sv = false;
        if ($request->status_for_decret == true) {
            $newItem->status = true;
        } else $newItem->status = false;
        if ($request->status_decret == true) {
            $newItem->status_decret = true;
        } else $newItem->status_decret = false;

        $newItem->save();

        if($request->status) {
            
            $cadryCreate = new CadryCreate();
            $cadryCreate->railway_id = $newItem->railway_id;
            $cadryCreate->organization_id = $newItem->organization_id;
            $cadryCreate->cadry_id = $newItem->cadry_id;
            $cadryCreate->command_number = $request->command_number;
            $cadryCreate->update_staff = true;
            $cadryCreate->save();
        }

        if ($request->staff_status == 0) {
            $cadry = Cadry::find($newItem->cadry_id);
            $cadry->department_id = $request->department_id;
            $cadry->staff_id = $editstaff->staff_id;
            $cadry->post_name = $editstaff->staff_full;
            $cadry->save();
        }

        if ($request->careerCheck == true) {
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
        $newDelCadry->date = $request->delete_date;
        $newDelCadry->save();

        $car = Career::find($request->career_id);
        $car->date2 = date("Y", strtotime($request->delete_date));
        $car->save();

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => "Xodim lavozimi muvaffaqqiyatli yakunlandi!"
        ]);
    }

    public function ExportToExcel()
    {
        $cadries = Cadry::ApiOrgFilter()->with(['education','birth_city','birth_region','pass_region','instituts', 'pass_city','address_region','address_city','nationality','education','party',
            'cadry_title','cadry_degree','allStaffs','allStaffs.department','allStaffs.staff.category','relatives','med','allStaffs.cadry.vacationExport'])->get();

        return response()->json(
            ExcelOrgResource::collection($cadries)
        );
    }


    public function api_cadry_passports($cadry_id)
    {
        $passports = Passport::where('cadry_id', $cadry_id)->get();

        return response()->json([
            'passports' => PassportResource::collection($passports)
        ]); 
    }

    public function api_add_passports_cadry($cadry_id, Request $request)
    {
        $validated = $request->validate([
            'file_path' => ['required', 'file']
        ]);

        $filenameWithExt = $request->file('file_path')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file('file_path')->getClientOriginalExtension();

        $fileName = $filename .'_'. time() . '.' . $extension;

        $path = $request->file_path->storeAs('passports', $fileName);

        $newfile = new Passport();
        $newfile->cadry_id = $cadry_id;
        $newfile->file_path = 'storage/' . $path;
        $newfile->file_extension = $extension;
        $newfile->save();

        return response()->json([
            'message' => "Passport muvaffaqqiyatli qo'shildi!"
        ]);
    }

    public function api_update_passports_cadry($passport_id, Request $request)
    {
        if ($request->file_path) {
            $validated = $request->validate([
                'file_path' => ['required', 'file']
            ]);

            $extension = $request->file('file_path')->getClientOriginalExtension();

            $filenameWithExt = $request->file('file_path')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $fileName = $filename .'_'. time() . '.' . $extension;

            $path = $request->file_path->storeAs('stafffiles', $fileName);

            $newfile = Passport::find($passport_id);
            $newfile->file_path = 'storage/' . $path;
            $newfile->file_extension = $extension;
            $newfile->save();
        }

        return response()->json([
            'message' => "Passport muvaffaqqiyatli taxrirlandi!"
        ]);
    }

    public function api_delete_passports_cadry(Passport $passport_id)
    {
        $passport_id->delete();

        return response()->json([
            'message' => "Passport muvaffaqqiyatli o'chirildi!"
        ]);
    }

    public function api_cadry_translate($cadry_id)
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

        $item = Cadry::find($cadry_id);

        $item->last_name = str_replace($cyr, $lat, $item->last_name);
        $item->first_name = str_replace($cyr, $lat, $item->first_name);
        $item->middle_name = str_replace($cyr, $lat, $item->middle_name);
        $item->post_name = str_replace($cyr, $lat, $item->post_name);
        $item->address = str_replace($cyr, $lat, $item->address);

        $infos = InfoEducation::where('cadry_id',$cadry_id)->get();

        foreach($infos as $info)
        {
            $info->institut = str_replace($cyr, $lat, $info->institut);
            $info->speciality = str_replace($cyr, $lat, $info->speciality);
            $info->save();
        }

        $careers = Career::where('cadry_id',$cadry_id)->get();

        foreach($careers as $career)
        {
            $career->staff = str_replace($cyr, $lat, $career->staff);
            $career->save();
        }

        $relatives = CadryRelative::where('cadry_id', $cadry_id)->get();

        foreach($relatives as $relative)
        {
            $relative->fullname = str_replace($cyr, $lat, $relative->fullname);
            $relative->birth_place = str_replace($cyr, $lat, $relative->birth_place);
            $relative->post = str_replace($cyr, $lat, $relative->post);
            $relative->address = str_replace($cyr, $lat, $relative->address);
            $relative->save();
        }

        $abroads = AbroadStudy::where('cadry_id', $cadry_id)->get();

        foreach($abroads as $abroad)
        {
            $abroad->institute = str_replace($cyr, $lat, $abroad->institute);
            $abroad->direction = str_replace($cyr, $lat, $abroad->direction);
            $abroad->save();
        }

        $depcadries = DepartmentCadry::where('cadry_id',$cadry_id)->get();

        foreach($depcadries as $depcadry)
        {
            $depcadry->staff_full = str_replace($cyr, $lat, $depcadry->staff_full);
            $depstaff = DepartmentStaff::find($depcadry->department_staff_id);
            $dep = Department::find($depcadry->department_id);
            $staff = Staff::find($depcadry->staff_id);

            $depstaff->staff_full = $depcadry->staff_full;
            $dep->name = str_replace($cyr, $lat, $dep->name);
            $staff->name = str_replace($cyr, $lat, $staff->name);

            $depcadry->save();
            $depstaff->save();
            $dep->save();
            $staff->save();
        }

        $disciplinaryactions = DisciplinaryAction::where('cadry_id',$cadry_id)->get();

        foreach($disciplinaryactions as $action)
        {
            $action->type_action = str_replace($cyr, $lat, $action->type_action);
            $action->reason_action = str_replace($cyr, $lat, $action->reason_action);
            $action->save();
        }

        $incentives = Incentive::where('cadry_id', $cadry_id)->get();

        foreach($incentives as $incentive)
        {
            $incentive->by_whom = str_replace($cyr, $lat, $incentive->by_whom);
            $incentive->number = str_replace($cyr, $lat, $incentive->number);
            $incentive->type_action = str_replace($cyr, $lat, $incentive->type_action);
            $incentive->type_reason = str_replace($cyr, $lat, $incentive->type_reason);
            $incentive->save();
        }

        $medicalExaminations = MedicalExamination::where('cadry_id',$cadry_id)->get();

        foreach($medicalExaminations as $med)
        {
            $med->result = str_replace($cyr, $lat, $med->result);
            $med->save();
        }

        $staff_files = StaffFile::where('cadry_id',$cadry_id)->get();

        foreach($staff_files as $staff_file)
        {
            $staff_file->comment = str_replace($cyr, $lat, $staff_file->comment);
            $staff_file->save();
        }


        $item->save();


        return response()->json([
            'message' => "Muvaffaqqiyatli o'zgartirildi!"
        ], 200);
    }
}
