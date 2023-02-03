<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;


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
       if($request->role === 'admin'){
        return back()->withSuccess('Admin create successful');
       }else{
        return back()->withSuccess('writer create successful');
       }

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
        $request->validate([
            "phone_number"=> "min:11",
            "profile_image"=>"mimes:jpg",
            "cover_photo"=>"mimes:jpg"
        ]);
        User::find($id)->update([
            "name"=>$request->name,
            "phone_number"=>$request->phone_number,
            "address"=>$request->address,
            "gender"=>$request->gender,

        ]);
        if ($request->hasFile('profile_image')) {
            $file_name= auth()->id().'.'.$request->file('profile_image')->getClientOriginalExtension();
            $img = Image::make($request->file('profile_image'));
            $img->save(base_path('public/upload/admin_profile_image/'.$file_name),80);
            User::find($id)->update([
                "profile_image"=> $file_name,
            ]);
        }
        if ($request->hasFile('cover_photo')) {
            $file_name= auth()->id().'.'.$request->file('cover_photo')->getClientOriginalExtension();
            $img = Image::make($request->file('cover_photo'));
            $img->save(base_path('public/upload/admin_cover_image/'.$file_name),80);
            User::find($id)->update([
                "cover_photo"=> $file_name,
            ]);
        }
        return back()->withSuccess('Profile Update successful');

    }
    //profile password update !!!! problem this code
    public function passwordUpdate(Request $request,$id){
        $request->validate([
            '*'=>'required',
            'new_password'=>['different:old_password','same:confirm_password']
        ]);
        if (Hash::check($request->old_password, auth()->user()->new_password)) {
            User::find($id)->update([
                'password'=>Hash::make($request->new_password)
            ]);
        }else{
            return back()->with('error','Old Password not correct');
        }
        return back()->withSuccess('Password Update successful');

    }

}


