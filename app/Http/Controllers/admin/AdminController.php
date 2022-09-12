<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // admin after login
    public function admin(){
        return view('adminHome');
    }

    // admin custom logout
    public function logout(){
        Auth::logout();
        $notification = array('messege'=>"you are logout!!!",'alert-type'=>'success');
        return redirect()->route('admin.login')->with($notification);
    }
// password change page
    public function PasswordChange(){
        return view('layouts.password_change');
         
    }
    public function PasswordUpdate(Request $request){
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',

        ]);

        $current_pass = Auth::user()->password;

        $oldpass=$request->old_password;//oldpassword get from input field
        $newpass=$request->password; // newpassword get for new password

        if(Hash::check($oldpass, $current_pass)){ //checking oldpassword and currentuser password same or not
            $user = User::findorfail(Auth::id()); // current user data get
            $user->password = Hash::make($request->password); //current user password hasing
            $user->save();// finally save the password
            Auth::logout(); // logout the admin user and redirect admin login panel not user login panel
            $notification = array('messege'=>" your password changed!",'alert-type'=>'success');
            return redirect()->route('admin.login')->with($notification);
        }else{
            $notification = array('messege'=>" Old password does not matched!",'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
    }
}
