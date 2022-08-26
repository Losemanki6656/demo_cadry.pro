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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Storage;
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

    public function export_excel(Request $request)
    {
       // $cadries = Cadry::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))
        //->with(['education','birth_city','birth_region','staff','pass_region','pass_city','address_region','address_city','nationality','education','party',
        //'cadry_title','cadry_degree','allStaffs','allStaffs.department','allStaffs.staff.category'])->get();

        //return view('export.export_cadry', [
         //   'cadries' => $cadries
        //]);
      
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
        foreach($request->cadries as $key => $value)
        {
            $val = Cadry::find($key);
            $char = ['(', ')', ' ','-','+'];
            $replace = ['', '', '','',''];
            $phone = str_replace($char, $replace, $val->phone);

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://91.204.239.44/broker-api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{ 
                "messages":
                [ 
                    {
                        "recipient": "'.$phone.'",
                        "message-id":"1",
                        "sms": 
                        {
                            "originator": "3700","content": 
                            {
                                "text": "'.$request->comment.'"
                            }
                        }
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YnV4b3JvdGVtaXJ5OnU4MjNTMkpwaQ==',
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);
            
            return redirect()->back()->with('msg' ,$response);
        }
        
    }

    public function user_edit()
    {
        $user = UserOrganization::where('user_id',Auth::user()->id)->with('organization')->get();

        return view('users.user-edit',[
            'user' => $user
        ]);   
    }

    public function user_edit_success($id,Request $request)
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
}
