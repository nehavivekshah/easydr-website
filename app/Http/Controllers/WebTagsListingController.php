<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController; 

use App\Models\Branches;
use App\Models\Roles;
use App\Models\Pharmacy_types;
use App\Models\Specialists;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use App\Models\Payment_gateway_configs;
use App\Models\Video_call_gateway_configs;
use App\Models\Dosages;
use App\Models\Frequencies;
use App\Models\Durations;
use App\Models\Routes;
use App\Models\Meals;

class WebtagsListingController extends Controller
{
    function meals(){
        
        $meals = Meals::get();
        
        return view('meals',['meals'=>$meals]);
    }
    function manageMeal(Request $request){
        
        $meal = Meals::where('id','=',($request->id))->first();
        
        return view('manageMeal',['meal'=>$meal]);
    }
    function manageMealPost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $meal = $id ? Meals::find($id) : new Meals();
    
        if (!$meal) {
            $meal = new Meals();
        }
    
        // Set the title field
        $meal->name = $request->name ?? '';
        
        // Save the specialist to the database
        if ($meal->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function routes(){
        
        $routes = Routes::get();
        
        return view('routes',['routes'=>$routes]);
    }
    function manageRoute(Request $request){
        
        $route = Routes::where('id','=',($request->id))->first();
        
        return view('manageRoute',['route'=>$route]);
    }
    function manageRoutePost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $route = $id ? Routes::find($id) : new Routes();
    
        if (!$route) {
            $route = new Routes();
        }
    
        // Set the title field
        $route->name = $request->name ?? '';
        
        // Save the specialist to the database
        if ($route->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function durations(){
        
        $durations = Durations::get();
        
        return view('durations',['durations'=>$durations]);
    }
    function manageDuration(Request $request){
        
        $duration = Durations::where('id','=',($request->id))->first();
        
        return view('manageDuration',['duration'=>$duration]);
    }
    function manageDurationPost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $duration = $id ? Durations::find($id) : new Durations();
    
        if (!$duration) {
            $duration = new Durations();
        }
    
        // Set the title field
        $duration->name = $request->name ?? '';
        
        // Save the specialist to the database
        if ($duration->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function frequencies(){
        
        $frequencies = Frequencies::get();
        
        return view('frequencies',['frequencies'=>$frequencies]);
    }
    function manageFrequency(Request $request){
        
        $frequency = Frequencies::where('id','=',($request->id))->first();
        
        return view('manageFrequency',['frequency'=>$frequency]);
    }
    function manageFrequencyPost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $frequency = $id ? Frequencies::find($id) : new Frequencies();
    
        if (!$frequency) {
            $frequency = new Frequencies();
        }
    
        // Set the title field
        $frequency->name = $request->name ?? '';
        
        // Save the specialist to the database
        if ($frequency->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function dosages(){
        
        $dosages = Dosages::get();
        
        return view('dosages',['dosages'=>$dosages]);
    }
    function manageDosage(Request $request){
        
        $dosage = Dosages::where('id','=',($request->id))->first();
        
        return view('manageDosage',['dosage'=>$dosage]);
    }
    function manageDosagePost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $dosage = $id ? Dosages::find($id) : new Dosages();
    
        if (!$dosage) {
            $dosage = new Dosages();
        }
    
        // Set the title field
        $dosage->name = $request->name ?? '';
        
        // Save the specialist to the database
        if ($dosage->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function notificationSettings(){
        
        $notifications = [];
        
        return view('notificationSettings',['notifications'=>$notifications]);
    }
    function pharmacyTypes(){
        $pharmacyTypes = Pharmacy_types::get();
        
        return view('pharmacyTypes',['pharmacyTypes'=>$pharmacyTypes]);
    }
    function managePharmacyType(Request $request){
        
        $pharmacyType = Pharmacy_types::where('id','=',($request->id))->first();
        
        return view('managePharmacyType',['pharmacyType'=>$pharmacyType]);
    }
    function managePharmacyTypePost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Pharmacy_types or create a new one
        $pharmacyTypes = $id ? Pharmacy_types::find($id) : new Pharmacy_types();
    
        if (!$pharmacyTypes) {
            $pharmacyTypes = new Pharmacy_types();
        }
    
        // Set the title field
        $pharmacyTypes->title = $request->title ?? '';
    
        // Save the Pharmacy_types to the database
        if ($pharmacyTypes->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function specialists(){
        
        $specialists = Specialists::get();
        
        return view('specialists',['specialists'=>$specialists]);
    }
    function manageSpecialist(Request $request){
        
        $specialist = Specialists::where('id','=',($request->id))->first();
        
        return view('manageSpecialist',['specialist'=>$specialist]);
    }
    function manageSpecialistPost(Request $request){
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $specialist = $id ? Specialists::find($id) : new Specialists();
    
        if (!$specialist) {
            $specialist = new Specialists();
        }
    
        // Set the title field
        $specialist->title = $request->title ?? '';

        if(!empty($request->file('icons'))):
            
            // $request->validate([
            //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            // ]);
            $fileName = time().".".$request->icons->extension();
            $request->icons->move(public_path("/assets/images/specialists"), $fileName);
        
            $specialist->icons = $fileName ?? '';

        endif;
    
        // Save the specialist to the database
        if ($specialist->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function cities(){
        
        $cities = Cities::get();
        
        return view('cities',['cities'=>$cities]);
    }
    function manageCity(Request $request){
        
        $cities = Cities::where('id','=',($request->id))->first();
        
        $states = States::where('status','=','1')->get();
        
        $countries = Countries::where('status','=','1')->get();
        
        return view('manageCity',['cities'=>$cities,'states'=>$states,'countries'=>$countries]);
    }
    function manageCityPost(Request $request){
        
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $city = $id ? Cities::find($id) : new Cities();
    
        if (!$city) {
            $city = new Cities();
        }
    
        // Set the title field
        $city->name = $request->name ?? '';
        $city->state = $request->state ?? '';
        $city->country = $request->country ?? '';
    
        // Save the specialist to the database
        if ($city->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function states(){
        
        $states = States::get();
        
        return view('states',['states'=>$states]);
    }
    function manageState(Request $request){
        
        $states = States::where('id','=',($request->id))->first();
        
        $countries = Countries::where('status','=','1')->get();
        
        return view('manageState',['states'=>$states,'countries'=>$countries]);
    }
    function manageStatePost(Request $request){
        
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $states = $id ? States::find($id) : new States();
    
        if (!$states) {
            $states = new States();
        }
    
        // Set the title field
        $states->name = $request->name ?? '';
        $states->country = $request->country ?? '';
    
        // Save the specialist to the database
        if ($states->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function countries(){
        
        $countries = Countries::get();
        
        return view('countries',['countries'=>$countries]);
    }
    function manageCountry(Request $request){
        
        $countries = Countries::where('id','=',($request->id))->first();
        
        return view('manageCountry',['countries'=>$countries]);
    }
    function manageCountryPost(Request $request){
        
        $id = $request->id ?? null;
    
        // Find the existing Specialist or create a new one
        $country = $id ? Countries::find($id) : new Countries();
    
        if (!$country) {
            $country = new Countries();
        }
    
        // Set the title field
        $country->name = $request->name ?? '';
    
        // Save the specialist to the database
        if ($country->save()) {
            return back()->with('success', 'Successfully Submitted');
        } else {
            return back()->with('error', 'Oops, Something went wrong.');
        }
    }
    function deleteRecord(Request $request){
        $id = $request->id ?? '';
        
        if(($request->page ?? '') == 'specialist'){
            // Perform the delete operation
            $record = Specialists::find($id);
        }elseif(($request->page ?? '') == 'city'){
            // Perform the delete operation
            $record = Cities::find($id);
        }elseif(($request->page ?? '') == 'state'){
            // Perform the delete operation
            $record = States::find($id);
        }elseif(($request->page ?? '') == 'country'){
            // Perform the delete operation
            $record = Countries::find($id);
        }elseif(($request->page ?? '') == 'pgc'){
            // Perform the delete operation
            $record = Payment_gateway_configs::find($id);
        }elseif(($request->page ?? '') == 'video_call_gateway_config'){
            // Perform the delete operation
            $record = Video_call_gateway_configs::find($id);
        }elseif(($request->page ?? '') == 'dosage'){
            // Perform the delete operation
            $record = Dosages::find($id);
        }elseif(($request->page ?? '') == 'frequency'){
            // Perform the delete operation
            $record = Frequencies::find($id);
        }elseif(($request->page ?? '') == 'duration'){
            // Perform the delete operation
            $record = Durations::find($id);
        }elseif(($request->page ?? '') == 'route'){
            // Perform the delete operation
            $record = Routes::find($id);
        }elseif(($request->page ?? '') == 'meal'){
            // Perform the delete operation
            $record = Meals::find($id);
        }
        
        if ($record) {
            $record->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Record not found.']);
    }
}
