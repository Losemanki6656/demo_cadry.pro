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
   
}
