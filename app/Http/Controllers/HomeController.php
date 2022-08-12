<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserSelect;
use App\Models\Enterprice;
use App\Models\SendTask;
use App\Models\SendTaskDate;
use App\Models\Quote;
use App\Models\SendFile;
use App\Models\Archive;
use App\Models\ArchiveFile;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Railway;
use App\Models\UserOrganization;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$all = User::find(1)->lastLoginIp();
        //dd($all);
        $quotrand = Quote::find(rand(1,8));

        return view('home',[
            'quotrand' => $quotrand
        ]);
    }
   
    function getOriginalClientIp(Request $request = null) : string
    {
        $request = $request ?? request();
        $xForwardedFor = $request->header('x-forwarded-for');
        if (empty($xForwardedFor)) {
            // Si está vacío, tome la IP del request.
            $ip = $request->ip();
        } else {
            // Si no, viene de API gateway y se transforma para usar.
            $ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
            $ip = $ips[0];
        }
        return $ip;
    }

    public function sendtask()
    {
        $str = UserSelect::where('user_id',Auth::user()->id)->value('selected_users');
        $users = User::find(explode(',',$str));
        $tasks = SendTask::with('user')->with('organization_rec')->where('send_id',Auth::user()->id)->with('recorganization')->get();
        //dd($tasks);
        return view('filemanager.sendtask',[
            'users' => $users,
            'tasks' => $tasks
        ]);
    }

    public function select_users()
    {

        $sel = [];
        $users = User::with('userorganization')->get();
        $str = UserSelect::where('user_id',Auth::user()->id)->value('selected_users');

        $organizations = Organization::all();
        $railways = Railway::all();
        $departments = Department::all();

        $selected_users = explode(',',$str);

        foreach ($users as $us)
            {
                $sel[$us->id] = 0;
                $x = 0;
                foreach ($selected_users as $value)
                {
                    if($us->id == $value)  $x++;
                 }
                 if($x != 0) $sel[$us->id] = 1;
            }

        return view('filemanager.select_users',[
            'users' => $users,
            'sel' => $sel,
            'organizations' => $organizations,
            'departments' => $departments,
            'railways' => $railways
        ]);
    }

    public function sel_users(Request $request)
    {
        $str = implode(',',$request->check);
        if(count(UserSelect::where('user_id',Auth::user()->id)->get()))
        {
            $newsel = UserSelect::where('user_id',Auth::user()->id)->first();
            $newsel->selected_users = $str;
            $newsel->save();
        }
        else
        {
            $newsel = new UserSelect();
            $newsel->user_id = Auth::user()->id;
            $newsel->selected_users = $str;
            $newsel->save();
        }

        return redirect()->back()->with('msg' ,1);
    }

    public function send_task(Request $request)
    {
            $usersend  = UserOrganization::where('user_id',Auth::user()->id)->get();
            $userrec = UserOrganization::where('user_id',$request->user_id)->get();

            $task = new SendTask();

            $task->org_send_id = $usersend[0]->value('organization_id');
            $task->dep_send_id = $usersend[0]->value('department_id');
            $task->org_rec_id = $userrec[0]->value('organization_id');
            $task->dep_rec_id =  $userrec[0]->value('department_id');

            $task->send_id = Auth::user()->id;
            $task->recipient_id = $request->user_id;
            $task->select_date = 0;
            $task->task_text = $request->task_text;
            $task->term = $request->date_1;
            $task->rec_status = 0;
            $task->task_status = 0;
            $task->save();
            
           
        return redirect()->back()->with('success', 'Success! User created');
    }

    public function send_files()
    {
        $str = UserSelect::where('user_id',Auth::user()->id)->value('selected_users');
        $users = User::find(explode(',',$str));
        $sendfiles = SendFile::where('send_id',Auth::user()->id)->with('user')->get();


        return view('filemanager.sendfiles',[
            'users' => $users,
            'sendfiles' => $sendfiles
        ]);
    }
    public function submit_file(Request $request)
    {
        //dd($request->all());
        $fileName = time().'.'.$request->file_path->extension();

        $path = $request->file_path->storeAs('public/files', $fileName);

        $sendfiles = new SendFile();
        $sendfiles->send_id = Auth::user()->id;
        $sendfiles->recipient_id = $request->user_id;
        $sendfiles->topic = $request->topic;
        $sendfiles->file_path = 'storage/files/' . $fileName;
        $sendfiles->term = $request->term;
        $sendfiles->rec_status = 0;
        $sendfiles->task_status = 0;
        $sendfiles->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_simp_task(Request $request)
    {
        $task =  SendTask::find($request->tasksimpid);
        $task->task_text = $request->tasksimptext;
        $task->term = $request->tasksimpterm;
        $task->save();

        return redirect()->back()->with('msg' ,2);
    }

    public function share_simp_task(Request $request)
    {
        $userrec  = UserOrganization::where('user_id',$request->usersharesimpid)->get();
        $usersend = UserOrganization::where('user_id',Auth::user()->id)->get();
        $task = new SendTask();

        $task->org_send_id = $usersend[0]->value('organization_id');
        $task->dep_send_id = $usersend[0]->value('department_id');
        $task->org_rec_id = $userrec[0]->value('organization_id');
        $task->dep_rec_id =  $userrec[0]->value('department_id');   

        $task->send_id = Auth::user()->id;
        $task->recipient_id = $request->usersharesimpid;
        $task->select_date = 0;
        $task->task_text = $request->tasksharesimptext;
        $task->term = $request->tasksharesimpdate;
        $task->rec_status = 0;
        $task->task_status = 0;
        $task->save();

        return redirect()->back()->with('msg' ,4);
    }

    public function success_simp_task(Request $request)
    {
        $task = SendTask::find($request->sucsimpid);
        $archive = new Archive();
        $archive->send_id = Auth::user()->id;
        $archive->recipient_id = $task->recipient_id;
        $archive->task_success_text = $task->task_text;
        $archive->success_date = $task->updated_at;
        $archive->task_term_date = $task->term;
        $archive->save();

        SendTask::find($request->sucsimpid)->delete();

        return redirect()->back()->with('msg' ,3);
    }

    public function delete_simp_task(Request $request)
    {
        SendTask::find($request->deletesimpid)->delete();

        return redirect()->back()->with('msg' ,5);
    }

    public function received()
    {
        $str = UserSelect::where('user_id',Auth::user()->id)->value('selected_users');
        $users = User::find(explode(',',$str));
        $tasks = SendTask::with('userrec')->where('recipient_id',Auth::user()->id)->get();
        
        foreach ($tasks as $task){
            $task->rec_status = 1;
            $task->save();
        }

        return view('filemanager.received',[
            'users' => $users,
            'tasks' => $tasks
        ]);
    }

    public function share_rec_task(Request $request)
    {
        $task = new SendTask();
        $task->send_id = Auth::user()->id;
        $task->recipient_id = $request->usershareid;
        $task->select_date = 0;
        $task->task_text = $request->tasktext;
        $task->term = $request->termdate;
        $task->rec_status = 0;
        $task->task_status = 0;
        $task->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function share_simp_rec_task(Request $request)
    {   
        $usersend  = UserOrganization::where('user_id', Auth::user()->id)->get();
        $userrec = UserOrganization::where('user_id', $request->usersimpshareid)->get();

        $task = new SendTask();

        $task->org_send_id = $usersend[0]->value('organization_id');
        $task->dep_send_id = $usersend[0]->value('department_id');
        $task->org_rec_id = $userrec[0]->value('organization_id');
        $task->dep_rec_id =  $userrec[0]->value('department_id');

        $task->send_id = Auth::user()->id;
        $task->recipient_id = $request->usersimpshareid;
        $task->select_date = 0;
        $task->task_text = $request->tasksimptext;
        $task->term = $request->termsimpdate;
        $task->rec_status = 0;
        $task->task_status = 0;
        $task->save();

        return redirect()->back()->with('msg' ,1);
    }
    public function success_rec_task(Request $request)
    {
        $sendrec = SendTaskDate::find($request->sucrecid);
        $sendrec->rec_status = 1;
        $sendrec->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function success_rec_simp_task(Request $request)
    {
        $sendrec = SendTask::find($request->sucrecsimpid);
        $sendrec->task_status = 1;
        $sendrec->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_file_task(Request $request)
    {

        $fileName = time().'.'.$request->file_path_edit->extension();

        $path = $request->file_path_edit->storeAs('files', $fileName);

        $sendfiles = SendFile::find($request->editfileid);
        $sendfiles->send_id = Auth::user()->id;
        $sendfiles->recipient_id = $request->usereditid;
        $sendfiles->topic = $request->topicedit;
        $sendfiles->file_path = 'storage/' . $path;
        $sendfiles->term = $request->editdateid;
        $sendfiles->rec_status = 0;
        $sendfiles->task_status = 0;
        $sendfiles->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function share_file_task(Request $request)
    {
        $sendfiles = SendFile::find($request->usshareid);

        $share = new SendFile();
        $share->send_id = Auth::user()->id;
        $share->recipient_id = $request->usshareselect;
        $share->topic = $sendfiles->topic;
        $share->file_path = $sendfiles->file_path;
        $share->term = $sendfiles->term;
        $share->rec_status = 0;
        $share->task_status = 0;
        $share->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function succ_file(Request $request)
    {
        $sendfiles = SendFile::find($request->sucfileid);
        $share = new ArchiveFile();
        $share->send_id = $sendfiles->send_id;
        $share->recipient_id = $sendfiles->recipient_id;
        $share->topic = $sendfiles->topic;
        $share->file_path = $sendfiles->file_path;
        $share->success_date = $sendfiles->updated_at;
        $share->file_term_date = $sendfiles->term;
        $share->save();
        SendFile::find($request->sucfileid)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function del_file(Request $request)
    {

        SendFile::find($request->delfileid)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function received_files()
    {
        $str = UserSelect::where('user_id',Auth::user()->id)->value('selected_users');
        $users = User::find(explode(',',$str));
        $sendfiles = SendFile::where('recipient_id',Auth::user()->id)->with('userrec')->get();

        foreach ($sendfiles as $sends){
            $sends->rec_status = 1;
            $sends->save();
        }

        return view('filemanager.received_files',[
            'users' => $users,
            'sendfiles' => $sendfiles
        ]);
    }

    public function share_rec_file(Request $request)
    {
        $share = new SendFile();
        $share->send_id = Auth::user()->id;
        $share->recipient_id = $request->usshareselect;
        $share->topic = $request->topic;
        $share->file_path = $request->file_path_share;
        $share->term = $request->dateshare;
        $share->rec_status = 0;
        $share->task_status = 0;
        $share->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function rec_suc_file(Request $request)
    {
        $share = SendFile::find($request->sucfileid);
        $share->task_status = 1;
        $share->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function archive_task()
    {
        $archives = Archive::where('send_id',Auth::user()->id)->with('user')->paginate(10);
        $archivefiles = ArchiveFile::where('send_id',Auth::user()->id)->with('user')->paginate(10);
          return view('filemanager.archive_task',[
           'archives' => $archives,
           'archivefiles' => $archivefiles
       ]);
    }
}
