<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminUserController extends Controller
{

    public function create(){
       $user_list = User::where([['role','admin'],['id','!=',auth()->id()]])->orWhere('role','writer')->paginate(5)->withQueryString();//admin,subscribe and writer list
        return view('users.create',compact('user_list'));
    }
    public function store(Request $request){
        $request->validate([
            '*'=>'required',
            'email'=>'email',
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 6 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);
       User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role'=>$request->role,
            'email_verified_at'=>now(),
            'created_at'=>now()
       ]);
       return back()->withSuccess('Admin || writer create successful');
    }

    //user delete method
    public function destroy($id){
        User::find($id)->delete();
        return back();
     }

     //profile edit
     public function edit(){
        return view('profile.edit');
     }
     //profile update
     public function update(Request $request,$id){
        User::find($id)->update([
            "name"=>$request->name,
            "phone_number"=>$request->phone_number,
            "address"=>$request->address,
            "gender"=>$request->gender,

        ]);
        return back()->withSuccess('Profile Update successful');
    }

}
