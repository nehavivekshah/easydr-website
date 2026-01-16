<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\Usermetas;
use App\Models\Chats;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return $this->successResponse($users, 'List of users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Check for unique email
        if (User::where('email', $request->email)->exists()) {
            return $this->errorResponse('Email already exists');
        }

        // Hash the password before saving
        $request->merge(['password' => Hash::make($request->password)]);
        
        $user = User::create($request->validated());
        
        if (!$user) {
            return $this->errorResponse('Oops!! Something went wrong');
        }
        
        $otp = date('is');
        $to = $user->email;
        $subject = $otp . " Account Verification Code";
        $message = "We have received an account verification request. The verification code to verify your account is below.<br>" . $otp . " is the account verification code.<br><br><b>Regards</b><br>Easy Doctor";
        $viewName = 'inc.sendmail';
        $viewData = ["name" => "Sir/Ma'am", "messages" => $message];
        
        try {
            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // If email sending fails, delete the created user
            $user->delete();
            return $this->errorResponse('Failed to send verification email');
        }
        
        // Return success response with OTP
        $response = $user->toArray();
        $response['otp'] = $otp;

        // Return success response
        return $this->successResponse($response, 'Successfully Registered!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return $this->errorResponse('User Not Found');
        }
    
        // Check the user's role
        if ($user->role == 4) {
            // Fetch Usermetas details
            $usermetas = Usermetas::where('uid', $id)->first();
            // Fetch doctor details
            $doctor = Doctors::where('uid', $id)->first();
            if (!$doctor) {
                return $this->errorResponse('Doctor details not found');
            }
            return $this->successResponse([
                'user' => $user,
                'usermetas_details' => $usermetas ?? '',
                'doctor_details' => $doctor
            ], 'Doctor details');
        } else {
            // Fetch Usermetas details
            $usermetas = Usermetas::where('uid', $id)->first();
            // Fetch patient details
            $patient = Patients::where('uid', $id)->first();
            // if (!$patient) {
            //     return $this->errorResponse('Patient details not found');
            // }
            return $this->successResponse([
                'user' => $user,
                'usermetas_details' => $usermetas ?? '',
                'patient_details' => $patient ?? ''
            ], 'Patient details');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return $this->errorResponse('User Not Found');
        }
        
        $user->update($request->validated());
        return $this->successResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return $this->errorResponse('User Not Found');
        }
        
        $user->delete();
        return $this->successResponse(null, 'User Deleted');
    }
    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $id = $request->uid;
        
        $user = User::find($id);
        
        if (!$user) {
            return $this->errorResponse('User Not Found');
        }
        
        $otp = date('is');
        $to = $user->email;
        $subject = $otp . " Account Verification Code";
        $message = "We have received an account verification request. The verification code to verify your account is below.<br>" . $otp . " is the account verification code.<br><br><b>Regards</b><br>Easy Doctor";
        $viewName = 'inc.sendmail';
        $viewData = ["name" => "Sir/Ma'am", "messages" => $message];
        
        try {
            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // If email sending fails, delete the created user
            $user->delete();
            return $this->errorResponse('Failed to send verification email');
        }
        
        // Return success response with OTP
        $response = $user->toArray();
        $response['otp'] = $otp;
        
        return $this->successResponse($response, 'OTP Resent Successfully',200);
    }
    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        
        $user = User::where('email', $request->email)->first();
        
        $otp = date('is');
        $to = $user->email;
        $subject = $otp . " Account Verification Code";
        
        $message = "
        <p>Dear User,</p>
        <p>We have received a request to reset the password for your account. Please use the verification code below to complete the process:</p>
        <h2>$otp</h2>
        <p>If you did not request a password reset, please ignore this email or contact support.</p>
        <p><b>Regards,</b><br>Easy Doctor Team</p>
        ";
        
        $viewName = 'inc.sendmail';
        $viewData = ["name" => "Sir/Ma'am", "messages" => $message];
        
        try {
            Mail::to($to)->send(new SendMail($subject, $viewName, $viewData));
        } catch (\Exception $e) {
            // If email sending fails, delete the created user
            $user->delete();
            return $this->errorResponse('Failed to send verification email');
        }
        
        // Return success response with OTP
        $response = $user->toArray();
        $response['otp'] = $otp;

        // Return success response
        return $this->successResponse($response, 'Successfully Registered!', 200);
    }
    
    function changePhoto($id, Request $request){
        
        $user = User::find($id);
        // Handle file attachment
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('assets/images/profiles'), $filename); // Move to the public directory
    
            $user->photo = $filename; // Save the relative file path in the database
        }
            
        $user->update();
        
        return $this->successResponse($user, 'Successfully Updated!', 200);
    }
    
    public function medicalReports($id)
    {
        $reports = Chats::where('pid', $id)->whereNotNull('file')->orderBy('created_at', 'desc')->get();
        return $this->successResponse($reports, 'Medical Reports Fetched Successfully');
    }
}
