<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Http\Resources\RoleAdminCollection;
use App\Http\Resources\PermissionAdminResource;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //$value = $request->session()->get('key');

        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function users()
    {
        $users = User::query()
        ->when(\Request::input('search'),function($query,$search){
            $query
            ->where('email','like','%'.$search.'%');
        })->
        whereNotIn('id',[1,3])->with(['userorganization','userorganization.organization'])->paginate(15);
    
        return view('admin.users',[
            'users' => $users
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function api_roles()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $roles = new RoleAdminCollection(Role::with('permissions')->paginate($per_page));

        return response()->json($roles);
    }

    public function api_role_pers($role_id)
    {
        $user_permissions = Role::with('permissions')->find($role_id)->permissions;

        $permissions = Permission::all()->map(function ($permission) use ($user_permissions) {

            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'check' => in_array($permission->id, $user_permissions->pluck('id')->toArray())
            ];
         });

        return response()->json($permissions);
    }

    public function api_role_pers_update($role_id, Request $request)
    {
        $arr = $request->all();

        $role = Role::find($role_id);

        foreach ($arr as $item)
        {
           if($item['check'] == true) {
                if(!$role->hasPermissionTo($item['name'])) 
                    $role->givePermissionTo($item['name']);
           } else if($role->hasPermissionTo($item['name'])) 
           $role->revokePermissionTo($item['name']);
        }

        return response()->json([
            'message' => "Permission successfully given to role!"
        ]);
    }

    public function api_role_delete(Role $role_id)
    {

        $users = User::all();

        foreach($users as $item)
        {
            if($item->hasRole($role_id->name)) {

                return response()->json([
                    'message' => "Dont remove role!"
                ], 403);
            }
                
        }

        $role_id->delete();

        return response()->json([
            'message' => "Role successfully deleted!"
        ]);
    }

    public function api_users()
    {

        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }
}