<?php

namespace App\Http\Controllers\API;

use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\User;

class userController extends Controller
{
    public function __construct()
    {        
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        return User::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user['id'],
            'password' => 'sometimes|string|min:6',
        ]);
        
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['type'] = $request['type'];
        $user['bio'] = $request['bio'];
        $user['photo'] = $request['photo'];
        if($request['password'] != ''){
            $user['password'] = Hash::make($request['password']);
        }
        $user->update();

        return ['message' => 'data updated!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'user deleted!'];
    }

    public function authProfile(){        
        return auth('api')->user();
    }

    public function updateAuthProfile(Request $request){        
        $req = new Request($request->all());

        $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$user['id'],
            'password' => 'sometimes|string|min:6',
        ]);
        
        $userPhoto = public_path('/img/uploads/').$user->photo;
        if ($request->hasFile('photo')) {
            if (file_exists($userPhoto)) {
                Storage::disk('uploads')->delete($user->photo);
            }
            $file = $request->file('photo');
            $fileName = '/' . time() . '.' . $file->getClientOriginalExtension();            
            Storage::disk('uploads')->put($fileName, file_get_contents($file->getRealPath()));
            
            $req->merge(['photo' => $fileName]);            
        }

        if (!empty($request->password)) {            
            $req->merge(['password' => Hash::make($request->password)]);        
        }

        $user->update($req->all());
        return $req->all();
    }

    public function searchUser($wildcard){
        $this->authorize('isAdmin');
       
        $query = $wildcard;
        $user = User::where('name','like',"%$query%")
                    ->orWhere('email','like',"%$query%")
                    ->orWhere('bio','like',"%$query%")
                    ->latest()
                    ->paginate(5);
        return $user;            
    }
}
