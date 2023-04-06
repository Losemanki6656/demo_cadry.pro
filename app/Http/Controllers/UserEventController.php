<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserEventLogCollection;
use App\Http\Resources\RevisionCollection;
use App\Models\UserEvent;
use App\Models\Revision;

class UserEventController extends Controller
{
    public function events_admin(Request $request) 
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $users = UserEvent::query()
            ->when(\Request::input('search'),function($query,$search){
                $query->orWhere('name', 'LIKE', '%'. $search .'%')
                    ->orWhere('browser', 'LIKE', '%'. $search .'%')
                    ->orWhere('ipAddress', 'LIKE', '%'. $search .'%')
                    ->orWhere('regionName', 'LIKE', '%'. $search .'%')
                    ->orWhere('email', 'LIKE', '%'. $search .'%');
            })
            ->when(\Request::input('status'),function($query,$status){
                $query->where('status', $status);
            })->paginate($per_page);
        
        return response()->json([
            'users' => new UserEventLogCollection($users)
        ]);
    } 

    public function events_organization(Request $request) 
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $users = UserEvent::query()
            ->where('user_id', auth()->user()->id)
            ->when(\Request::input('search'),function($query,$search){
                $query->orWhere('name', 'LIKE', '%'. $search .'%')
                    ->orWhere('browser', 'LIKE', '%'. $search .'%')
                    ->orWhere('ipAddress', 'LIKE', '%'. $search .'%')
                    ->orWhere('regionName', 'LIKE', '%'. $search .'%')
                    ->orWhere('email', 'LIKE', '%'. $search .'%');
            })
            ->when(\Request::input('status'),function($query,$status){
                $query->where('status', $status);
            })->paginate($per_page);
        
        return response()->json([
            'users' => new UserEventLogCollection($users)
        ]);
    } 

    public function revisionables()
    {
        if(request('per_page')) $per_page = request('per_page'); else $per_page = 10;

        $username = request('username');

        $revisions = Revision::query()
            ->when(request('search'),function($query,$search){
                $query->orWhere('revisionable_type', 'LIKE', '%'. $search .'%')
                    ->orWhere('key', 'LIKE', '%'. $search .'%')
                    ->orWhere('revisionable_id', 'LIKE', '%'. $search .'%')
                    ->orWhere('old_value', 'LIKE', '%'. $search .'%')
                    ->orWhere('new_value', 'LIKE', '%'. $search .'%');
            })
            ->with(['user' => function($q) use($username) {
                $q->where('name', $username);
            }])
            ->orderBy('created_at','desc')->paginate($per_page);
        
        return response()->json([
            'revisions' => new RevisionCollection($revisions)
        ]);
    }
}
