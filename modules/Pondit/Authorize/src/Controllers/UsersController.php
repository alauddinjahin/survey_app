<?php

namespace Pondit\Authorize\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Pondit\Authorize\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;

class UsersController extends Controller
{
    public static $visiblePermissions = [
        'index'=>'Dashboard'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users   = User::orderBy('created_at','desc')->get();

        if(!is_null($users)){
            foreach( $users as $user){
                $user->is_online() ? $user->status = "<i class='mdi mdi-record text-success'>online</i>" : $user->status = "<i class='mdi mdi-record text-danger'>offline</i>";
            }
        }

        return view('vendor.authorize.users.index', compact('users'));
    }
    

    public function create_new_user(Request $request)
    {
        try {

            $data = $request->all();

            if(array_key_exists('email',$data))
            {
                $find = User::where('email',$data['email'])->first();
                if(!is_null($find))
                    throw new Exception("Email Already Exists", 403);
                    
            }


            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'is_active' => $data['is_active'],
            ]);

            if(!$user)
                throw new Exception("Unable to create user", 403);
                

            return response()->json([
                'success'   => true,
                'data'      => $user,
                'msg'       => 'User created Successfully!',
            ],201);

        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'data'      => null,
                'msg'       => $e->getMessage(),
            ],$e->getCode());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        return view('vendor.authorize.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        try 
        {
            $this->photo=null;
            $requestData = $request->all();
            if(array_key_exists('name',$requestData) && is_null($requestData['name']))
            throw new Exception("Name is Requied!", 403);
            

            if(array_key_exists('email',$requestData) && is_null($requestData['email']))
                throw new Exception("Email is Requied!", 403);

            if(array_key_exists('role_id',$requestData) && is_null($requestData['role_id']))
                throw new Exception("Role is Requied!", 403);

            $user = User::findOrFail($id);

            if($request->hasFile('photo')){
                if (!is_null($user->photo)) $this->unlink($user->photo,'/app/public/users/');
                $this->photo = $this->uploadImage($request->photo, $user->name);
                $requestData['photo']= $this->photo;
                
            }   

                
            $update = $user->update($requestData);

            Session::flash('flash_message', 'User updated!');
                        
            if(array_key_exists('from_profile',$requestData) && $requestData['from_profile']=='true'){
                return redirect()->route('users.loadAuthUserProfile');
            }

            return redirect(Config("authorization.route-prefix") . '/users');


        } catch (\Exception $e) 
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect(Config("authorization.route-prefix") . '/users');
    }

    public function updateUserStatus(Request $request)
    {
        try 
        {
            $req_data = $request->only('id','is_active');
            if(!array_key_exists('id',$req_data))
                throw new Exception("Reference is Not found!", 403);

            $status   = User::where('id',$req_data['id'])->update(['is_active'=>boolval($req_data['is_active'])]);
            if(!$status)    
                throw new Exception("Unable to changed Status!", 403);

            return response()->json([
                'success'   => true,
                'data'      => User::find($req_data['id']),
                'msg'       => 'Status Changed Successfully!',
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'data'      => null,
                'msg'       => $e->getMessage(),
            ],$e->getCode());
        }
    }


    public function loadAuthUserProfile()
    {
        return view('backend.auth-user.profile');
    }



    private function uploadImage($file, $name)
    {

        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
        $file_name = $timestamp .'-'.$name. '.' . $file->getClientOriginalExtension();
        $path = storage_path().'/app/public/users/';
        $pathToUpload = $path.$file_name;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        Image::make($file)->resize(80,80)->save($pathToUpload);
        return $file_name;
    }


    private function unlink($file,$path)
    {
        $pathToUpload = storage_path().$path;

        if ($file != '' && file_exists($pathToUpload. $file)) {
            @unlink($pathToUpload. $file);
        }
    }



}
