<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserOrganization;
use Validator;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;

use Jenssegers\Agent\Agent;

use App\Models\UserEvent;
use Storage;
use File;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request){

    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 404);
        }

        return $this->createNewToken($token);
    }

    public function userProfile(Request $request){

        $events = [];
        $data = \Location::get($request->ip()); 
        $agent = new Agent();

        $events[] = [
            'browser' => $agent->browser(),
            'version' => $agent->version($agent->browser()),
            'platform' => $agent->platform(),
            'ipAddress' => $request->ip() ?? null,
            'countryName' =>  $data->countryName ?? null,
            'countryCode' => $data->countryCode ?? null,
            'regionCode' => $data->regionCode ?? null,
            'regionName' => $data->regionName ?? null,
            'cityName' => $data->cityName ?? null,
            'latitude' => $data->latitude ?? null,
            'longitude' => $data->longitude ?? null,
            'areaCode' => $data->areaCode ?? null,
            'timezone' => $data->timezone ?? null,
            'pathInfo' => $request->url(),
            'requestUri' => $request->getRequestUri(),
            'method' => $request->method(),
            'content' => $request->getContent(),
            'regexp' => $agent->match('regexp'),
            'device' => $agent->device(),
            'user_id' => auth()->user()->id,
            'fullname' => auth()->user()->name,
            'email' => auth()->user()->email,
            'status' => true
        ];
        
        UserEvent::create($events[0]);

        $user = new UserResource(User::find(auth()->user()->id));

        return response()->json($user);

    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
                
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        auth('api')->logout();

        $events = [];
        $data = \Location::get($request->ip()); 

        $events[] = [
            'browser' => $agent->browser(),
            'version' => $agent->version($agent->browser()),
            'platform' => $agent->platform(),
            'ipAddress' => $request->ip ?? null,
            'countryName' =>  $data->countryName ?? null,
            'countryCode' => $data->countryCode ?? null,
            'regionCode' => $data->regionCode ?? null,
            'regionName' => $data->regionName ?? null,
            'cityName' => $data->cityName ?? null,
            'latitude' => $data->latitude ?? null,
            'longitude' => $data->longitude ?? null,
            'areaCode' => $data->areaCode ?? null,
            'timezone' => $data->timezone ?? null,
            'pathInfo' => $request->url(),
            'requestUri' => $request->getRequestUri(),
            'method' => $request->method(),
            // 'userAgent' => $request->header('User-Agent'),
            'content' => $request->getContent(),
            'header' => $agent->match('regexp'),
            'device' => $agent->device(),
            'user_id' => auth()->user()->id,
            'status' => false
        ];
        
        UserEvent::create($events[0]);

        $user = new UserResource(User::find(auth()->user()->id));


        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('api')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'created_at' => now()
        ]);
    }


    public function update_user(Request $request)
    {

        $validated = $request->validate([
            'email' => ['required','unique:users,email,'.auth()->user()->id],
            'photo' => ['file'],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'name' => 'required',
            'phone' => ['required','regex:/[0-9]/','regex:/[()+-]/','not_regex:/[a-z]/','not_regex:/[A-Z]/','not_regex:/[@$!%*#?&]/','min:18']
        ]);

        $user = auth()->user();
      
        if($request->photo) {

            $fileName   = time() . $request->photo->getClientOriginalName();
            Storage::disk('public')->put('users/' . $fileName, File::get($request->photo));
            $file_name  = $request->photo->getClientOriginalName();
            $file_type  = $request->photo->getClientOriginalExtension();
            $filePath   = 'storage/users/' . $fileName;

            $user->update($request->all());

            $userOrgan = UserOrganization::where('user_id', $user->id)->first();
            $userOrgan->update([
                'photo' => $filePath,
                'phone' => $request->phone,
                'post_id' => $request->password,
            ]);

            return response()->json([
                'message' => 'success'
            ]);

        } else  {

            $user->update($request->all());

            $userOrgan = UserOrganization::where('user_id', $user->id)->first();
            $userOrgan->update([
                'phone' => $request->phone,
                'post_id' => $request->password,
            ]);

            return response()->json([
                'message' => 'success'
            ]);
        }
    }

}