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
use App\Models\SlugCadry;
use App\Models\InfoEducation;
use App\Models\Career;
use App\Models\CadryRelative;

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

    public function slug_cadries()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $slugs = SlugCadry::where('status', false)->orderBy('created_at','desc')->with(['cadry','user','railway','organization'])->paginate($per_page);
        $slug = Slug::where('user_id', auth()->user()->id)->first();
        if($slug) $slug = $slug->name; else $slug = null;

        return response()->json([
            'slug' => $slug,
            'slug_cadries' => new SlugCollection($slugs)
        ]);
    }

    public function slug_create()
    {
        Slug::where('organization_id',auth()->user()->userorganization->organization_id)->delete();

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
            'url' => $randomString,
            'expires_at' => $slug->expires_at,
            'created_at' => $slug->created_at
        ]);
    }

    public function delete_slug_cadry($slug_cadry_id)
    {
        $slug = SlugCadry::find($slug_cadry_id);
        $cadry_id = $slug->cadry_id;
        $slug->delete();

        DepartmentCadry::where('cadry_id',$cadry_id)->delete();
        Career::where('cadry_id',$cadry_id)->delete();
        CadryRelative::where('cadry_id',$cadry_id)->delete();
        DemoCadry::where('cadry_id',$cadry_id)->delete();
        CadryCreate::where('cadry_id',$cadry_id)->delete();
        Cadry::find($cadry_id)->delete();
        
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }

    public function accept_slug_cadry($slug_cadry_id)
    {
        $slug = SlugCadry::find($slug_cadry_id);
        $slug->user_id = auth()->user()->id;
        $slug->status = true;
        $slug->save();

        if($slug->cadry_id) 
        {   
            $cadry = Cadry::find($slug->cadry_id);
            $cadry->status = true;
            $cadry->save();
        }

        return response()->json([
            'message' => 'successfully accepted'
        ]);
    }

    public function slug_click($slug)
    {
        $item = Slug::where('name', $slug)->first();
        
        if($item) {

            if($item->expired()) {

                return response()->json([
                    'message' => 'Not Found',
                ], 404);

            } else {
                
                $relatives = CadryRelativeResource::collection(Relative::all());
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
            'education_id' => ['required'],
            'academictitle_id' => ['required'],
            'academicdegree_id' => ['required'],
            'nationality_id' => ['required'],
            'language' => ['required'],
            'party_id' => ['required'],
            'military_rank' => ['required'],
            'deputy' => ['required'],
            'phone' => ['required'],
            'photo' => ['file']
        ]);

        $organ = Slug::where('name', $slug)->first();

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
                    $array['stavka'] = 1;
                    $array['post_date'] = now();
                    $array['job_date'] = now();

                    
                    $cadry = Cadry::create($array);

                    foreach($request->institut as $item)
                    {
                        $neweducation = new InfoEducation();
                        $neweducation->cadry_id = $cadry->id;
                        $neweducation->sort = 0;
                        $neweducation->date1 = $item['date1'];
                        $neweducation->date2 = $item['date2'];
                        $neweducation->institut = $item['name'];
                        $neweducation->speciality = $item['spec'];
                        $neweducation->save();
                    }

                    foreach($request->career as $car)
                    {
                        $career = new Career();
                        $career->cadry_id = $cadry->id;
                        $career->sort = 0;
                        $career->date1 = $car['date1'];
                        $career->date2 = $car['date2'];
                        $career->staff = $car['staff'];
                        $career->save();
                    }

                    foreach($request->relatives as $relative)
                    {
                        $rel = new CadryRelative();
                        $rel->cadry_id = $cadry->id;
                        $rel->relative_id = $relative['relative_id'];
                        $rel->sort = 0;
                        $rel->fullname = $relative['fullname'];
                        $rel->birth_place = $relative['birth_place'];
                        $rel->post = $relative['post'];
                        $rel->address = $relative['address'];
                        $rel->save();
                    }

                    $slug = new SlugCadry();
                    $slug->railway_id = $organ->railway_id;
                    $slug->organization_id = $organ->organization_id;
                    $slug->user_id = $organ->user_id;
                    $slug->cadry_id = $cadry->id;
                    $slug->save();

                    return response()->json([
                        'status' => 3,
                        'message' => "Xodim muvaffaqqiyatli qo'shildi!"
                    ]);;
                }

            } else {
                return response()->json([
                    'message' => 'Not Found',
                ], 404);
            }

        } else {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }
            
    }

}
