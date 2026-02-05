<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WebAuthController;
use Carbon\Carbon;

use App\Models\Branches;
use App\Models\User;
use App\Models\Usermetas;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\Roles;

class WebUserController extends Controller
{
    function users($type = null)
    {

        /*if(Auth::user()->role == '0'){

            $users = User::leftjoin('branches','users.branch','=','branches.id')
                ->leftjoin('roles','users.role','=','roles.id')
                ->select('branches.name','roles.title','roles.subtitle','users.*')->get();

            $roles = Roles::where('branch','=',(Auth::user()->branch ?? ''))->get();

        }*/

        if ($type == 'admin-accounts') {

            $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
                ->leftjoin('roles', 'users.role', '=', 'roles.id')
                ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->leftjoin('patients', 'users.id', '=', 'patients.uid')
                ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
                ->select(
                    'branches.name as company',
                    'usermetas.designation',
                    'usermetas.adhar',
                    'usermetas.address',
                    'usermetas.city',
                    'usermetas.state',
                    'usermetas.country',
                    'usermetas.pincode',
                    'patients.blood_group',
                    'patients.medical_file',
                    'patients.height',
                    'patients.weight',
                    'patients.health_card',
                    'patients.hc_verified_at',
                    'patients.health_card_file',
                    'patients.marital_status',
                    'doctors.specialist',
                    'doctors.license',
                    'doctors.education',
                    'doctors.about',
                    'roles.title',
                    'roles.subtitle',
                    'users.*'
                )
                ->where('users.branch', '=', (Auth::user()->branch ?? ''))
                ->where('roles.features', '=', 'All')
                ->orderBy('users.created_at', 'DESC')->get();

        } elseif ($type == 'staff-accounts') {

            $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
                ->leftjoin('roles', 'users.role', '=', 'roles.id')
                ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->leftjoin('patients', 'users.id', '=', 'patients.uid')
                ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
                ->select(
                    'branches.name as company',
                    'usermetas.designation',
                    'usermetas.adhar',
                    'usermetas.address',
                    'usermetas.city',
                    'usermetas.state',
                    'usermetas.country',
                    'usermetas.pincode',
                    'patients.blood_group',
                    'patients.medical_file',
                    'patients.height',
                    'patients.weight',
                    'patients.health_card',
                    'patients.hc_verified_at',
                    'patients.health_card_file',
                    'patients.marital_status',
                    'doctors.specialist',
                    'doctors.license',
                    'doctors.education',
                    'doctors.about',
                    'roles.title',
                    'roles.subtitle',
                    'users.*'
                )
                ->where('users.branch', '=', (Auth::user()->branch ?? ''))
                ->where('users.role', '!=', '4')
                ->where('users.role', '!=', '5')
                ->where('roles.features', '!=', 'All')
                ->orderBy('users.created_at', 'DESC')->get();

        } elseif ($type == 'doctor-directory') {

            $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
                ->leftjoin('roles', 'users.role', '=', 'roles.id')
                ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->leftjoin('patients', 'users.id', '=', 'patients.uid')
                ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
                ->select(
                    'branches.name as company',
                    'usermetas.designation',
                    'usermetas.adhar',
                    'usermetas.address',
                    'usermetas.city',
                    'usermetas.state',
                    'usermetas.country',
                    'usermetas.pincode',
                    'patients.blood_group',
                    'patients.medical_file',
                    'patients.height',
                    'patients.weight',
                    'patients.health_card',
                    'patients.hc_verified_at',
                    'patients.health_card_file',
                    'patients.marital_status',
                    'doctors.specialist',
                    'doctors.fees',
                    'doctors.wallet',
                    'doctors.license',
                    'doctors.education',
                    'doctors.about',
                    'roles.title',
                    'roles.subtitle',
                    'users.*'
                )
                ->where('users.branch', '=', (Auth::user()->branch ?? ''))
                ->where('users.role', '=', '4')
                ->orderBy('users.created_at', 'DESC')->get();

        } elseif ($type == 'patient-directory') {

            $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
                ->leftjoin('roles', 'users.role', '=', 'roles.id')
                ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->leftjoin('patients', 'users.id', '=', 'patients.uid')
                ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
                ->select(
                    'branches.name as company',
                    'usermetas.designation',
                    'usermetas.adhar',
                    'usermetas.address',
                    'usermetas.city',
                    'usermetas.state',
                    'usermetas.country',
                    'usermetas.pincode',
                    'patients.blood_group',
                    'patients.medical_file',
                    'patients.height',
                    'patients.weight',
                    'patients.health_card',
                    'patients.hc_verified_at',
                    'patients.health_card_file',
                    'patients.hc_issue_date',
                    'patients.hc_expairy_date',
                    'patients.marital_status',
                    'doctors.specialist',
                    'doctors.license',
                    'doctors.education',
                    'doctors.about',
                    'roles.title',
                    'roles.subtitle',
                    'users.*'
                )
                ->where('users.branch', '=', (Auth::user()->branch ?? ''))
                ->where('users.role', '=', '5')
                ->orderBy('users.created_at', 'DESC')->get();

        } else {

            $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
                ->leftjoin('roles', 'users.role', '=', 'roles.id')
                ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->leftjoin('patients', 'users.id', '=', 'patients.uid')
                ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
                ->select(
                    'branches.name as company',
                    'usermetas.designation',
                    'usermetas.adhar',
                    'usermetas.address',
                    'usermetas.city',
                    'usermetas.state',
                    'usermetas.country',
                    'usermetas.pincode',
                    'patients.blood_group',
                    'patients.medical_file',
                    'patients.height',
                    'patients.weight',
                    'patients.health_card',
                    'patients.hc_verified_at',
                    'patients.health_card_file',
                    'patients.marital_status',
                    'doctors.specialist',
                    'doctors.license',
                    'doctors.education',
                    'doctors.about',
                    'roles.title',
                    'roles.subtitle',
                    'users.*'
                )
                ->where('users.branch', '=', (Auth::user()->branch ?? ''))
                ->orderBy('users.created_at', 'DESC')->get();

        }

        return view('users', ['users' => $users, 'type' => $type]);
    }
    public function patientHealthCard()
    {
        $patients = Patients::leftJoin('users', 'patients.uid', '=', 'users.id')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'patients.health_card',
                'patients.health_card_file',
                'patients.hc_issue_date',
                'patients.hc_expairy_date',
                'patients.hc_verified_at'
            )
            ->where('users.role', 5) // Patient role
            ->where('users.branch', Auth::user()->branch)
            ->orderBy('users.created_at', 'DESC')
            ->get();

        return view('patient-health-card', compact('patients'));
    }
    public function verifyHealthCard(Request $request)
    {
        $patient = Patients::where('uid', $request->user_id)->firstOrFail();

        // If trying to VERIFY (currently not verified)
        if (!$patient->hc_verified_at) {

            // 1. Check if Health Card Number exists
            if (empty($patient->health_card)) {
                return back()->with('error', 'Cannot verify: Health Card Number is missing.');
            }

            // 2. Check if Health Card File exists
            if (empty($patient->health_card_file)) {
                return back()->with('error', 'Cannot verify: Health Card File is missing.');
            }

            // 3. Check for Expiry
            if (empty($patient->hc_expairy_date)) {
                return back()->with('error', 'Cannot verify: Expiry Date is missing.');
            }

            $expiryDate = Carbon::parse($patient->hc_expairy_date);
            if ($expiryDate->isPast()) {
                return back()->with('error', 'Cannot verify: Health Card has expired.');
            }

            $patient->hc_verified_at = Carbon::now(); // Verify
            $message = 'Health card successfully verified.';

        } else {
            // Un-verify
            $patient->hc_verified_at = null;
            $message = 'Health card verification removed.';
        }

        $patient->save();

        return redirect('/admin/patient-health-card')->with('success', $message);
    }
    public function editPatientHealthCard($id)
    {
        $patient = User::leftJoin('patients', 'users.id', '=', 'patients.uid')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'patients.health_card',
                'patients.hc_issue_date',
                'patients.hc_expairy_date',
                'patients.health_card_file'
            )
            ->where('users.id', $id)
            ->firstOrFail();

        return view('edit-patient-health-card', compact('patient'));
    }
    public function updatePatientHealthCard(Request $request, $id)
    {
        $patient = Patients::where('uid', $id)->firstOrFail();

        $patient->health_card = $request->health_card;
        $patient->hc_issue_date = $request->hc_issue_date;
        $patient->hc_expairy_date = $request->hc_expairy_date;

        if ($request->hasFile('health_card_file')) {
            $file = $request->file('health_card_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/healthCards'), $filename);
            $patient->health_card_file = $filename;
        }

        $patient->save();

        return redirect('/admin/patient-health-card')
            ->with('success', 'Health Card updated successfully');
    }
    function manageNewUser($type, Request $request)
    {

        if ($type == 'patient-directory') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '=', '5')->get();

        } elseif ($type == 'doctor-directory') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '=', '4')->get();

        } elseif ($type == 'admin-accounts') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('features', '=', 'All')->get();

        } else {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '!=', '4')
                ->where('id', '!=', '5')
                ->where('features', '!=', 'All')->get();

        }

        return view('manageUser', ['roles' => $roles, 'type' => $type]);
    }
    function manageUser($type, $id = null, Request $request)
    {

        $segment = $request->segment(1);

        if ($segment == 'my-profile') {
            $uid = Auth::user()->id ?? '';
        } else {
            $uid = $id ?? '';
        }

        $users = User::leftjoin('branches', 'users.branch', '=', 'branches.id')
            ->leftjoin('roles', 'users.role', '=', 'roles.id')
            ->leftjoin('usermetas', 'users.id', '=', 'usermetas.uid')
            ->leftjoin('patients', 'users.id', '=', 'patients.uid')
            ->leftjoin('doctors', 'users.id', '=', 'doctors.uid')
            ->select(
                'branches.name as company',
                'usermetas.designation',
                'usermetas.adhar',
                'usermetas.address',
                'usermetas.city',
                'usermetas.state',
                'usermetas.country',
                'usermetas.pincode',
                'patients.blood_group',
                'patients.medical_file',
                'patients.height',
                'patients.weight',
                'patients.health_card',
                'patients.health_card_file',
                'patients.marital_status',
                'patients.family_doctor_id',
                'doctors.specialist',
                'doctors.license',
                'doctors.education',
                'doctors.fees',

                'doctors.experience',
                'doctors.extra',
                'doctors.about',
                'roles.title',
                'roles.subtitle',
                'users.*'
            )
            ->where('users.id', '=', $uid)->first();

        if ($type == 'patient-directory') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '=', '5')->get();

        } elseif ($type == 'doctor-directory') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '=', '4')->get();

        } elseif ($type == 'admin-accounts') {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('features', '=', 'All')->get();

        } else {

            $roles = Roles::where('branch', '=', (Auth::user()->branch ?? ''))
                ->where('id', '!=', '4')
                ->where('id', '!=', '5')
                ->where('features', '!=', 'All')->get();

        }

        $doctors = User::where('branch', (Auth::user()->branch ?? ''))
            ->where('role', 4)
            ->select('id', 'first_name', 'last_name')
            ->get();

        return view('manageUser', ['users' => $users, 'roles' => $roles, 'type' => $type, 'id' => $id, 'doctors' => $doctors]);
    }
    function manageUserPost(Request $request)
    {
        if ($request->filled('adhar')) {
            $request->validate([
                'adhar' => 'numeric|digits:12',
            ]);
        }

        // Check if the user exists or if it's a new entry
        $user = $request->id ? User::find($request->id) : new User();

        $type = $request->pagetype ?? '';
        // Set username and name fields
        $username = explode('@', $request->email);
        $name = explode(' ', $request->name);

        // Set user details
        $user->branch = Auth::user()->branch ?? '';
        $user->username = $username[0] . substr($request->mob, 0, 3);
        $user->first_name = $name[0] ?? '';
        $user->last_name = $name[1] ?? '';
        $user->email = $request->email ?? '';
        $user->mobile = $request->mob ?? '';
        $user->altr_mobile = $request->altr_mob ?? $request->mob2 ?? '';

        if (!empty($request->file('profile_photo'))):

            // $request->validate([
            //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            // ]);
            $fileName = time() . "." . $request->profile_photo->extension();
            $request->profile_photo->move(public_path("/assets/images/profiles"), $fileName);

            $user->photo = $fileName ?? 'default_photo.png';

        endif;

        // Only update password if it's provided
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->dob = $request->dob ?? '';
        $user->gender = $request->gender ?? '';
        $user->role = $request->role ?? Auth::User()->role;
        $user->status = $request->status ?? Auth::User()->status;

        // Save or update the user
        if ($request->id) {

            $user->update();

            if (!empty($request->country) || !empty($request->pincode) || !empty($request->designation) || !empty($request->adhar)) {

                $um = Usermetas::where('uid', '=', ($request->id ?? ''))->first();

                $usermeta = $um ? $um : new Usermetas();

                $usermeta->uid = $user->id ?? '';
                $usermeta->designation = $request->designation ?? '';
                if (!empty($request->adhar)) {
                    $usermeta->adhar = $request->adhar ?? '';
                    $usermeta->adhar_verified_at = NOW();
                }
                $usermeta->address = $request->address ?? '';
                $usermeta->city = $request->city ?? '';
                $usermeta->state = $request->state ?? '';
                $usermeta->country = $request->country ?? '';
                $usermeta->pincode = $request->pincode ?? '';
                $usermeta->save();

            }

            if ($type == 'patient-directory') {

                $pu = Patients::where('uid', '=', ($request->id ?? ''))->first();

                $patient = $pu ? $pu : new Patients();

                //$patient = new Patients();

                $patient->uid = $user->id ?? '';
                $patient->blood_group = $request->bloodgroup ?? '';

                if (!empty($request->file('medical_file'))):

                    // $request->validate([
                    //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                    // ]);
                    $fileName1 = time() . "." . $request->medical_file->extension();
                    $request->medical_file->move(public_path("/assets/images/medicals"), $fileName1);

                    $patient->medical_file = $fileName1 ?? '';

                endif;

                if (!empty($request->file('health_card_file'))):

                    // $request->validate([
                    //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                    // ]);
                    $fileName2 = time() . "." . $request->health_card_file->extension();
                    $request->health_card_file->move(public_path("/assets/images/healthCards"), $fileName2);

                    $patient->health_card_file = $fileName2 ?? '';

                endif;

                $patient->height = $request->height ?? '';
                $patient->weight = $request->weight ?? '';

                // Family Doctor Logic
                $familyDoctorId = $request->family_doctor_id;
                if (!empty($request->new_doc_name) && !empty($request->new_doc_mobile)) {
                    $newDoc = new User();
                    $newDoc->branch = Auth::user()->branch ?? 1;
                    $newDoc->first_name = $request->new_doc_name;
                    $newDoc->mobile = $request->new_doc_mobile;
                    $newDoc->email = $request->new_doc_email ?? null;
                    $newDoc->role = 4;
                    $newDoc->status = 1;
                    $newDoc->password = Hash::make('12345678');
                    $newDoc->save();

                    $docProfile = new Doctors();
                    $docProfile->uid = $newDoc->id;
                    $docProfile->save();

                    $familyDoctorId = $newDoc->id;
                }
                $patient->family_doctor_id = $familyDoctorId;

                if (!empty($request->health_card)) {
                    $patient->health_card = $request->health_card ?? '';
                    $patient->hc_verified_at = NOW();
                }

                $patient->marital_status = $request->marital_status ?? '';
                $patient->save();
            }

            if ($type == 'doctor-directory') {

                $du = Doctors::where('uid', '=', ($request->id ?? ''))->first();

                $doctor = $du ? $du : new Doctors();

                //$doctor = new Doctors();

                $doctor->uid = $user->id ?? '';
                $doctor->specialist = $request->specialization ?? '';
                $doctor->license = $request->license ?? '';
                $doctor->education = $request->education ?? '';
                $doctor->about = $request->about ?? '';
                $doctor->fees = $request->fees ?? '';
                $doctor->experience = $request->experience ?? '';
                $doctor->extra = $request->extra ?? '';
                $doctor->save();

            }

            if ($request->is_frontend) {
                return redirect('/my-profile')->with('success', 'Profile updated successfully.');
            }

            if ($request->segment(2) == 'my-profile') {
                return redirect('/admin/my-profile/' . $type . '/' . $request->id)->with('success', 'Successfully updated.');

            } else {
                return redirect('/admin/manage-user/' . $type . '/' . $request->id)->with('success', 'Successfully updated.');
            }

        } else {

            $user->save();

            if (!empty($request->country) || !empty($request->pincode) || !empty($request->designation) || !empty($request->adhar)) {

                $usermeta = new Usermetas();

                $usermeta->uid = $user->id ?? '';
                $usermeta->designation = $request->designation ?? '';
                if (!empty($request->adhar)) {
                    $usermeta->adhar = $request->adhar ?? '';
                    $usermeta->adhar_verified_at = NOW();
                }
                $usermeta->address = $request->address ?? '';
                $usermeta->city = $request->city ?? '';
                $usermeta->state = $request->state ?? '';
                $usermeta->country = $request->country ?? '';
                $usermeta->pincode = $request->pincode ?? '';
                $usermeta->save();

            }

            if ($type == 'patient-directory') {

                $patient = new Patients();

                $patient->uid = $user->id ?? '';
                $patient->blood_group = $request->bloodgroup ?? '';

                if (!empty($request->file('medical_file'))):

                    // $request->validate([
                    //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                    // ]);
                    $fileName1 = time() . "." . $request->medical_file->extension();
                    $request->medical_file->move(public_path("/assets/images/medicals"), $fileName1);

                    $patient->medical_file = $fileName1 ?? '';

                endif;

                if (!empty($request->file('health_card_file'))):

                    // $request->validate([
                    //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                    // ]);
                    $fileName2 = time() . "." . $request->health_card_file->extension();
                    $request->health_card_file->move(public_path("/assets/images/healthCards"), $fileName2);

                    $patient->health_card_file = $fileName2 ?? '';

                endif;

                $patient->height = $request->height ?? '';
                $patient->weight = $request->weight ?? '';

                // Family Doctor Logic
                $familyDoctorId = $request->family_doctor_id;
                if (!empty($request->new_doc_name) && !empty($request->new_doc_mobile)) {
                    $newDoc = new User();
                    $newDoc->branch = Auth::user()->branch ?? 1;
                    $newDoc->first_name = $request->new_doc_name;
                    $newDoc->mobile = $request->new_doc_mobile;
                    $newDoc->email = $request->new_doc_email ?? null;
                    $newDoc->role = 4;
                    $newDoc->status = 1;
                    $newDoc->password = Hash::make('12345678');
                    $newDoc->save();

                    $docProfile = new Doctors();
                    $docProfile->uid = $newDoc->id;
                    $docProfile->save();

                    $familyDoctorId = $newDoc->id;
                }
                $patient->family_doctor_id = $familyDoctorId;

                if (!empty($request->health_card)) {
                    $patient->health_card = $request->health_card ?? '';
                    $patient->hc_verified_at = NOW();
                }

                $patient->marital_status = $request->marital_status ?? '';

                $patient->save();

            }

            if ($type == 'doctor-directory') {

                $doctor = new Doctors();

                $doctor->uid = $user->id ?? '';
                $doctor->specialist = $request->specialization ?? '';
                $doctor->license = $request->license ?? '';
                $doctor->education = $request->education ?? '';
                $doctor->about = $request->about ?? '';

                $doctor->save();

            }

            return redirect('/admin/users/' . $type)->with('success', 'New user role was successfully added.');

        }

        return redirect('/admin/users/' . $type . '/' . $request->id)->with('error', 'Opps! Something has gone wrong.');
    }
    function resetPassword()
    {
        return view('resetPassword');
    }
    function resetPasswordPost(Request $request)
    {

        // Validate the required fields
        $request->validate([
            'cur_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed', // Confirm password validation
        ]);

        $id = Auth::User()->id;

        // Find the user
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Verify the current password
        if (!Hash::check($request->cur_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect with success message
        return redirect('/admin/reset-password')->with(
            'success',
            'Your new password has been successfully changed!'
        );

    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            // Delete related records
            // Note: In a real app, you might want to soft-delete or check for dependencies (like appointments)
            DB::table('usermetas')->where('uid', $id)->delete();
            DB::table('patients')->where('uid', $id)->delete();
            DB::table('doctors')->where('uid', $id)->delete();

            // Delete user
            $user->delete();

            return back()->with('success', 'User and related records deleted successfully.');
        }
        return back()->with('error', 'User not found.');
    }
}
