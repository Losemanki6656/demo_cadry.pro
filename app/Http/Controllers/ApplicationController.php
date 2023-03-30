<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadry;
use App\Models\Slug;
use App\Models\WorkStatus;
use App\Models\Region;
use App\Models\City;
use App\Models\Nationality;
use App\Models\Language;
use App\Models\AcademicTitle;
use App\Models\AcademicDegree;
use App\Models\Party;
use App\Models\Education;
use App\Models\WorkLevel;
use App\Models\Relative;

use Illuminate\Support\Str;
use App\Http\Resources\SlugCollection;
use App\Http\Resources\CadryRelativeResource;
use App\Http\Resources\WorkStatusResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\NationalityResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\AcademicTitleResource;
use App\Http\Resources\AcademicDegreeResource;
use App\Http\Resources\PartyResource;
use App\Http\Resources\EducationResource;

class ApplicationController extends Controller
{
    
    public function find_cadry(Request $request)
    {
        $passport = str_replace('-', ' ', $request->passport);
        $jshshir = str_replace('-', '', $request->jshshir);

        $cadry = Cadry::where('status', true)->where('birht_date', $request->birht_date)->where('jshshir', $jshshir)->where('passport', $passport)->first();

        if(!$cadry) {
            return response()->json([
                'message' => "Exodim Platformasida bunday xodim topilmadi yoki Platformadagi ma'lumotlarga siz to'ldirgan ma'lumotlar mos kelmadi..."
            ], 403);
        } else
        return app(\App\Http\Controllers\OrganizationController::class)->word_export_api($cadry->id);
    }

    public function slugs()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $slugs = Slug::where('status', false)->orderBy('created_at','desc')->with(['cadry','user','railway','organization'])->paginate($per_page);

        return response()->json([
            'slugs' => new SlugCollection($slugs)
        ]);
    }

    public function slug_create()
    {
        $randomString = Str::random(60);
        
        $slug = new Slug();
        $slug->railway_id = auth()->user()->userorganization->railway_id;
        $slug->organization_id = auth()->user()->userorganization->organization_id;
        $slug->user_id = auth()->user()->id;
        $slug->name = $randomString;
        $slug->expires_at = 21600;
        $slug->save();

        return response()->json([
            'message' => 'successfully gnerated',
            'url' => url(asset('odas/reception/' . $randomString)),
        ]);
    }

    public function delete_slug($slug)
    {
        $slug = Slug::find($slug)->delete();

        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }

    public function accept_slug($slug)
    {
        $slug = Slug::find($slug);
        $slug->status = true;
        $slug->save();

        return response()->json([
            'message' => 'successfully accepted'
        ]);
    }

    public function slug_click($slug)
    {
        $item = Slug::where('status', false)->where('name', $slug)->first();
        
        if($item) {

            if($item->expired()) {

                return response()->json([
                    'message' => 'Not Found',
                ], 404);

            } else {
                

                $relatives =  CadryRelativeResource::collection(Relative::all());
                $work_statuses = WorkStatusResource::collection(WorkStatus::get());
                $data1 = RegionResource::collection(Region::get());
                $data2 = CityResource::collection(City::get());
                $data4 = NationalityResource::collection(Nationality::get());
                $data5 = LanguageResource::collection(Language::get());
                $data6 = AcademicTitleResource::collection(AcademicTitle::get());
                $data7 = AcademicDegreeResource::collection(AcademicDegree::get());
                $data8 = PartyResource::collection(Party::get());
                $data9 = WorkLevel::get();
        
                $data10 = EducationResource::collection(Education::get());
        
                return response()->json([
                    'work_statuses' => $work_statuses,
                    'regions' => $data1,
                    'cities' => $data2,
                    'nationalities' => $data4,
                    'languages' => $data5,
                    'academictitlies' => $data6,
                    'academicdegree' => $data7,
                    'parties' => $data8,
                    'worklevels' => $data9,
                    'educations' => $data10,
                    'relatives' => $relatives,
                    'expires_at' => $item->expires_at,
                    'created_at' => $item->created_at
                ]);
            }
            
        } else {
            
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }
      
    }

    public function slug_add_worker($slug, Request $request)
    {      
        
        $validated = $request->validate([
            'last_name' => ['required'],
            'first_name' => ['required'],
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

        $organ = Slug::where('name', $slug)->where('status', false)->fisrt();

        if($organ) {

            if(!$organ->expired()) {


                $validator = Cadry::where('jshshir', $request->jshshir)->with('organization')->first();

                if ($validator) {

                    if($validator->status)
                    {
                        return response()->json([
                            'status' => 1,
                            'fullname' => $validator->last_name . ' ' . $validator->first_name . ' ' . $validator->middle_name,
                            'organization' => $validator->organization->name
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 2,
                            'message' => "Ushbu xodim arxivda mavjud"
                        ], 200);
                    }

                } else {

                    $array = $request->all();
                    $array['railway_id'] = $organ->railway_id;
                    $array['organization_id'] = $organ->organization_id;
                    $array['post_name'] = '';
                    $array['staff_id'] = null;
                    $array['middle_name'] = $request->middle_name ?? '';
                    $array['status'] = false;

                    
                    $cadry = Cadry::create($array);

                    return response()->json([
                        'status' => 4,
                        'message' => "Xodim muvaffaqqiyatli qo'shildi!"
                    ]);;
                }


            }

        }
       


      
    }

}
