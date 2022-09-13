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

class BackApiController extends Controller
{
    
    public function api_permissions()
    {
        
    }

    public function api_cadry_edit($id)
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

        return response()->json([
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
}