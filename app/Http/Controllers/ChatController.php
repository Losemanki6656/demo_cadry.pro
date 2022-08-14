<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Classification;
use App\Models\DepartmentStaff;
use App\Models\Department;
use App\Models\Cadry;
use Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('filemanager.chat');
    }

    public function sms($phone, $text)
    {

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
                            "text": "'.$text.'"
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

        return $response;
    }

    public function addstaffToDepartment($id)
    {
        $org_id = Auth::user()->userorganization->organization_id;
        $department = Department::find($id);
        $staffs = Staff::where('organization_id',$org_id)->get();
        $depstaff = DepartmentStaff::where('department_id',$id)->with(['department','staff','cadry'])->get();

        return view('cadry.addstaffdep',[
            'staffs' => $staffs,
            'depstaff' => $depstaff,
            'department' => $department
        ]);
    }
    public function loadClassification(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Classification::where('name_uz','LIKE',"%$search%")
            ->OrWhere('code_staff','LIKE',"%$search%")
            ->take(50)->get();
        }
        return response()->json($data);
    }

    public function loadCadry(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            
            $data = Cadry::OrgFilter()
                    ->where(function ($query) use ($search) {
                        $query->Orwhere('last_name','like','%'.$search.'%')
                            ->orWhere('first_name','like','%'.$search.'%')
                            ->orWhere('middle_name','like','%'.$search.'%');
                    })
                ->get();

        }
        return response()->json($data);
    }

    public function stafftoDepartment(Request $request)
    {
        $newItem = new DepartmentStaff();
        $newItem->railway_id = Auth::user()->userorganization->railway_id;
        $newItem->organization_id = Auth::user()->userorganization->organization_id;
        $newItem->department_id = $request->department_id;
        $newItem->staff_id = $request->staff_id;
        if($request->status_sv == 'on') {
            $newItem->status_sv = true;
        }
        if($request->cadry_id){
            $newItem->cadry_id = $request->cadry_id;
            $newItem->status = true;
        }
        $newItem->save();

        $StaffClass = Staff::find($request->staff_id);
        $StaffClass->classification_id = $request->class_staff_id;
        $StaffClass->save();

        if($request->cadry_id){
            $cadry = Cadry::find($request->cadry_id);
            $cadry->department_id = $request->department_id;
            $cadry->staff_id = $request->staff_id;
            $cadry->save();
        }

        return redirect()->back()->with('msg' ,1);
    }
}
