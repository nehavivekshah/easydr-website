<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Patients;
use Carbon\Carbon;

class AuthController extends ApiController
{
    /**
     * Handle user login.
     */
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            $id = $user->id;
            $name = $user->first_name . ' ' . $user->last_name;
            $role = $user->role;
    
            $photoUrl = !empty($user->photo)
                ? 'https://easydr.webbrella.in/public/assets/images/profiles/' . $user->photo
                : "";
    
            // Fetch the Specialist field from the doctors table
            $doctor = Doctors::where('uid', $user->id)->first();
    
            $specialist = $doctor ? $doctor->specialist : "";
            $wallet = $doctor ? $doctor->wallet : 0;
            
            $patients = Patients::where('uid', $user->id)->first();
            $hcNo = $patients->health_card ?? '';
            $hcFile = $patients->health_card_file ?? '';
            
            if (!empty($patients->hc_verified_at) && ($patients->hc_verified_at <= Carbon::now())) {
                $hcStatus = 1; // already verified
            } else {
                $hcStatus = 0; // not yet verified
            }

            // Return the plain text token
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            return $this->successResponse(
                [
                    'token' => $token,
                    'role' => $role,
                    'id' => $id,
                    'name' => $name,
                    'photoUrl' => $photoUrl,
                    'specialist' => $specialist,
                    'wallet' => $wallet,
                    'hcNo' => $hcNo,
                    'hcFile' => $hcFile,
                    'hcStatus' => $hcStatus
                ],
                'Login successful'
            );
        } else {
            return $this->errorResponse('Invalid email or password');
        }
    }


    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->successResponse(null, 'Logout successful');
    }
}
