<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Branches;
use App\Models\User;
use App\Models\Roles;

class WebAuthController extends Controller
{
    public function register() {
        return view('register');
    }
    
    public function registerPost(Request $request) {
        
        try {
            $branches = new Branches();
            
            $branches->name = $request->reg_company ?? '';
            $branches->mob = $request->reg_mob ?? '';
            $branches->email = $request->reg_email ?? '';
            $branches->gst = $request->reg_gst ?? '';
            $branches->status = '1';
    
            $branches->save();
            
            $user = new User();
        
            $username = explode('@',$request->reg_email);
            
            $user->username = substr($request->reg_company,0,3).$username[0];
            $user->name = $request->reg_name ?? '';
            $user->branch = $branches->id ?? '';
            $user->mob = $request->reg_mob ?? '';
            $user->email = $request->reg_email ?? '';
            $user->password = Hash::make($request->reg_password);
            $user->role = '1';
            
            $user->save();
            
            $roles = new Roles();
            
            $roles->branch = $branches->id ?? '';
            $roles->title = 'Admin';
            $roles->subtitle = 'Master';
            $roles->features = 'All';
            $roles->permissions = 'All';
            $roles->status = '1';
            
            $roles->save();
    
            return redirect('/admin/login')->with('success', 'Successfully registered your business on our platform! To complete the setup, please verify your email and fill out your business profile to start reaching potential customers.');
    
            return back()->with('error', 'Oops, Somethings went worng.');
            
        } catch (Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return back()->with('error', 'Duplicate Entry.');
            }
            return back()->with('error', 'Oops, Somethings went worng.');
        }
        
    }
    
    public function login() {
        return view('login');
    }
    
    public function loginPost(Request $request) {

        $credetials = [
            'email' => $request->login_email,
            'password' => $request->login_password,
        ];
        
        if(Auth::attempt($credetials)){
            
            // Get the authenticated user
            $user = Auth::user();
            
            $company = Branches::where('id','=',($user->branch ?? ''))->first();
            
            $roles = Roles::where('id','=',($user->role ?? ''))->first();
            
            // Store companies in session
            session(['companies' => $company]);
            session(['roles' => $roles]);
            
            return redirect('/admin')->with('success', 'Successfully Login.');
        }

        return back()->with('error', 'Login Credetials Invalid.');
    }
    
    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }
}
