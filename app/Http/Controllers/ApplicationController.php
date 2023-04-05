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
use App\Models\DepartmentStaff;
use App\Models\DepartmentCadry;
use App\Models\CadryCreate;
use App\Models\DemoCadry;
use App\Models\Department;

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
use App\Http\Resources\ViewSlugResource;
use App\Http\Resources\InfoEducationResource;
use App\Http\Resources\CareerResource;
use App\Http\Resources\RelativesResource;
use App\Http\Resources\DepResource;

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

    public function accept_cadry()
    {
        $work_statuses = WorkStatusResource::collection(WorkStatus::get());
        $departments = Department::where('organization_id',auth()->user()->userorganization->organization_id)->get();
        return response()->json([
            'work_statuses' => $work_statuses,
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
            'departments' => DepResource::collection($departments),
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
        CadryCreate::where('cadry_id', $cadry_id)->delete();
        Cadry::find($cadry_id)->delete();
        
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }

    public function view_slug_cadry(SlugCadry $slug_cadry_id)
    {
        $id = $slug_cadry_id->cadry_id;

        $languages = Language::all();
        $cadry = new ViewSlugResource(Cadry::with(['birth_city','birth_region','instituts'])->find($id));
        $lan = "";
        foreach ($languages as $language) {
           if (in_array($language->id, explode(',',$cadry->language) )) 
                $lan = $lan.$language->name.',';
        }
        $lan = substr_replace($lan ,"", -1);
        $carers = Career::where('cadry_id',$id)->orderBy('sort','asc')->get();
        $cadry_relatives = CadryRelative::where('cadry_id',$id)->with('relative')->orderBy('sort','asc')->get();

        return response()->json([
            'cadry' => $cadry,
            'lan' => $lan,
            'educations' =>  InfoEducationResource::collection($cadry->instituts),
            'carers' => CareerResource::collection($carers),
            'relatives' =>  RelativesResource::collection($cadry_relatives),
        ]);
    }

    public function accept_slug_cadry($slug_cadry_id, Request $request)
    {
        $slug = SlugCadry::find($slug_cadry_id);
        $slug->user_id = auth()->user()->id;
        $slug->status = true;
        $slug->save();

        $org = auth()->user()->userorganization;

        $dep = DepartmentStaff::with('cadry')->find($request->department_staff_id);

        $newItem = new DepartmentCadry();
        $newItem->railway_id = $org->railway_id;
        $newItem->organization_id = $org->organization_id;
        $newItem->department_id = $request->department_id;
        $newItem->department_staff_id = $request->department_staff_id;
        $newItem->staff_id = $dep->staff_id;
        $newItem->staff_full = $dep->staff_full;
        $newItem->staff_date = $request->staff_date;
        $newItem->staff_status = $request->staff_status;
        $newItem->command_number = $request->command_number;
        $newItem->razryad = $request->rank ?? 0;
        $newItem->koef = $request->coefficient ?? 0;
        $newItem->min_sum = $request->min_sum ?? 0;

        if($request->work_status_id == 2)
        {
            $newItem->work_status_id = $request->work_status_id;
            $newItem->work_date1 = $request->work_date1;
            $newItem->work_date2 = $request->work_date2;
        } else {
            $newItem->work_status_id = $request->work_status_id;
            $newItem->work_date1 = null;
            $newItem->work_date2 = null;
        }

        if($dep->stavka < $dep->cadry->sum('stavka') +  $request->rate) 
            $newItem->status_sv = true; 
        else
            $newItem->status_sv = false;

        $newItem->cadry_id = $slug->cadry_id;
        $newItem->stavka = $request->rate;
        $newItem->save();
                
        $cadr = Cadry::find($slug->cadry_id);
        $cadr->railway_id = $org->railway_id;
        $cadr->organization_id = $org->organization_id;
        $cadr->department_id = $request->department_id;
        $cadr->post_name = $dep->staff_full;
        $cadr->status = true;
        $cadr->save();

        $cadryCreate = new CadryCreate();
        $cadryCreate->railway_id = $org->railway_id;
        $cadryCreate->organization_id = $org->organization_id;
        $cadryCreate->cadry_id = $cadr->id;
        $cadryCreate->command_number = $request->command_number;
        $cadryCreate->comment = $request->comment;
        $cadryCreate->save();
        

        $x = Career::where('cadry_id', $slug->cadry_id)->count();
        $y = new Career();
        $y->sort = $x + 1;
        $y->cadry_id = $slug->cadry_id;
        $y->date1 = $request->staff_date;
        $y->date2 = '';
        $y->staff = $dep->staff_full;
        $y->save();

        return response()->json([
            'message' => "Xodim ma'lumotlari muvaffaqqiyatli yuklandi!"
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
                            'message' => "Xurmatli " . $validator->last_name . ' ' . $validator->first_name . ' ' . $validator->middle_name . ". Sizning ma'lumotlaringiz " .  $validator->organization->name 
                            . " korxonasi ma'lumotlar bazasida mavjud. 
                            Xodimlar bo'limi bilan bo'g'lanishingizni so'raymiz!"
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 2,
                            'message' => "Xurmatli " . $validator->last_name . ' ' . $validator->first_name . ' ' . $validator->middle_name . ". Sizning ma'lumotlaringiz ma'lumotlar bazasi arxivida mavjud. 
                            Xodimlar bo'limi bilan bo'g'lanishingizni so'raymiz!"
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

                    foreach(json_decode($request->institut) as $item)
                    {
                        $neweducation = new InfoEducation();
                        $neweducation->cadry_id = $cadry->id;
                        $neweducation->sort = 0;
                        $neweducation->date1 = $item->date1;
                        $neweducation->date2 = $item->date2;
                        $neweducation->institut = $item->name;
                        $neweducation->speciality = $item->spec;
                        $neweducation->save();
                    }

                    foreach(json_decode($request->career) as $car)
                    {
                        $career = new Career();
                        $career->cadry_id = $cadry->id;
                        $career->sort = 0;
                        $career->date1 = $car->date1;
                        $career->date2 = $car->date2;
                        $career->staff = $car->staff;
                        $career->save();
                    }

                    foreach(json_decode($request->relatives) as $relative)
                    {
                        $rel = new CadryRelative();
                        $rel->cadry_id = $cadry->id;
                        $rel->relative_id = $relative->relative_id;
                        $rel->sort = 0;
                        $rel->fullname = $relative->fullname;
                        $rel->birth_place = $relative->birth_place;
                        $rel->post = $relative->post;
                        $rel->address = $relative->address;
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
