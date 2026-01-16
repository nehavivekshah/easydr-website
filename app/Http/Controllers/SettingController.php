<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController; 

use App\Models\Branches;
use App\Models\Roles;
use App\Models\Pages;
use App\Models\Payment_gateway_configs;
use App\Models\Video_call_gateway_configs;

class SettingController extends Controller
{
    function roleSettings(){
        
        $roles = Roles::leftjoin('branches','roles.branch','=','branches.id')
            ->select('branches.name','roles.*')
            ->where('roles.branch','=',(Auth::user()->branch ?? ''))->get();
        
        return view('roleSettings',['roles'=>$roles]);
        
    }
    function manageRoleSettings(Request $request){
        
        $roles = Roles::leftjoin('branches','roles.branch','=','branches.id')
            ->select('branches.name','roles.*')
            ->where('roles.id','=',($request->id ?? ''))->first();
        
        return view('manageRole',['roles'=>$roles]);
    }
    function manageRoleSettingsPost(Request $request){
        
        // Extracting and processing permissions
        $permissions = $request->input('permissions', []); // Default to empty array if none are selected

        $featurePermissions = [];
        foreach ($permissions as $feature => $actions) {
            foreach ($actions as $action) {
                $featurePermissions[] = "{$feature}_{$action}";
            }
        }
        
        $features = implode(',', array_keys($permissions));
        
        $access = implode(',', $featurePermissions);
        
        if(empty($request->id)){
            
            $roleSettings = new Roles();
            
            $roleSettings->branch = (Auth::user()->branch ?? '');
            $roleSettings->title = ($request->role ?? '');
            $roleSettings->subtitle = ($request->subrole ?? '');
            $roleSettings->features = $features;
            $roleSettings->permissions = $access;
            $roleSettings->status = ($request->status ?? '');
            
            $roleSettings->save();
            
            return redirect('/admin/manage-role-setting')->with('success', 'New user role was successfully added.');
            
            return redirect('/admin/manage-role-setting')->with('error', 'Opps! Something has gone wrong.');
            
        }else{
            
            $id = $request->id ?? '';
            
            $roleSettings = Roles::find($id);
            
            $roleSettings->branch = (Auth::user()->branch ?? '');
            $roleSettings->title = ($request->role ?? '');
            $roleSettings->subtitle = ($request->subrole ?? '');
            $roleSettings->features = $features;
            $roleSettings->permissions = $access;
            $roleSettings->status = ($request->status ?? '');
            
            $roleSettings->update();
            
            return redirect('/admin/manage-role-setting?id='.$id)->with('success', 'Successfully updated.');
            
            return redirect('admin/manage-role-setting?id='.$id)->with('error', 'Opps! Something has gone wrong.');
            
        }
        
    }
    function paymentGatewayConfigs(){
        
        $pgc = Payment_gateway_configs::get();
        
        return view('paymentGatewayConfigs',['pgc'=>$pgc]);
        
    }
    function managePaymentGatewayConfig(Request $request){
        
        $pgc = Payment_gateway_configs::where('id','=',($request->id ?? ''))->first();
        
        return view('managePaymentGatewayConfig',['pgc'=>$pgc]);
    }
    public function managePaymentGatewayConfigPost(Request $request)
    {
        $request->validate([
            'gateway_name'      => 'required|string|max:255',
            'merchant_id'       => 'required|string|max:255',
            'api_key'           => 'required|string|max:255',
            'api_secret'        => 'required|string|max:255',
            'webhook_secret'    => 'nullable|string|max:255',
            'environment'       => 'required|in:sandbox,production',
            'is_active'         => 'required|boolean',
            'additional_config' => 'nullable|json',
        ]);
    
        if (empty($request->id)) {
            // Create new record
            $pg = new Payment_gateway_configs();
    
            $pg->gateway_name      = $request->gateway_name;
            $pg->merchant_id       = $request->merchant_id;
            $pg->api_key           = $request->api_key;
            $pg->api_secret        = $request->api_secret;
            $pg->webhook_secret    = $request->webhook_secret;
            $pg->environment       = $request->environment;
            $pg->is_active         = $request->is_active;
            $pg->additional_config = $request->additional_config ?? '{}';
    
            $pg->save();
    
            return redirect('/admin/payment-gateway-configs')->with('success', 'Payment Gateway configuration added successfully.');
        } else {
            // Update existing record
            $pg = Payment_gateway_configs::find($request->id);
    
            if (!$pg) {
                return redirect('/admin/payment-gateway-configs')->with('error', 'Configuration not found.');
            }
    
            $pg->gateway_name      = $request->gateway_name;
            $pg->merchant_id       = $request->merchant_id;
            $pg->api_key           = $request->api_key;
            $pg->api_secret        = $request->api_secret;
            $pg->webhook_secret    = $request->webhook_secret;
            $pg->environment       = $request->environment;
            $pg->is_active         = $request->is_active;
            $pg->additional_config = $request->additional_config ?? '{}';
    
            $pg->save();
    
            return redirect('/admin/manage-payment-gateway-config?id=' . $pg->id)->with('success', 'Payment Gateway configuration updated successfully.');
        }
    }
    function videoCallGatewayConfigs(){
        
        $vcgc = Video_call_gateway_configs::get();
        
        return view('videoCallGatewayConfigs',['vcgc'=>$vcgc]);
        
    }
    function manageVideoCallGatewayConfig(Request $request){
        
        $vcgc = Video_call_gateway_configs::where('id','=',($request->id ?? ''))->first();
        
        return view('manageVideoCallGatewayConfig',['vcgc'=>$vcgc]);
    }
    public function manageVideoCallGatewayConfigPost(Request $request)
    {
        $request->validate([
            'provider_name'     => 'required|string|max:255',
            'app_id'            => 'nullable|string|max:255',
            'app_secret'        => 'nullable|string|max:255',
            'api_key'           => 'nullable|string|max:255',
            'api_secret'        => 'nullable|string|max:255',
            'webhook_secret'    => 'nullable|string|max:255',
            'environment'       => 'nullable|in:sandbox,production',
            'is_active'         => 'nullable|boolean',
            'additional_config' => 'nullable|string',
        ]);
    
        try {
            if (empty($request->id)) {
                // Create new config
                $config = new Video_call_gateway_configs();
                $message = 'New Video Call Gateway Config was successfully added.';
            } else {
                // Update existing config
                $config = Video_call_gateway_configs::findOrFail($request->id);
                $message = 'Video Call Gateway Config was successfully updated.';
            }
    
            $config->provider_name     = $request->provider_name;
            $config->app_id            = $request->app_id;
            $config->app_secret        = $request->app_secret;
            $config->api_key           = $request->api_key;
            $config->api_secret        = $request->api_secret;
            $config->webhook_secret    = $request->webhook_secret;
            $config->environment       = $request->environment;
            $config->is_active         = $request->is_active ?? 0;
            $config->additional_config = $request->additional_config;
    
            $config->save();
    
            return redirect('/admin/video-call-gateway-configs')
                ->with('success', $message);
    
        } catch (\Exception $e) {
            \Log::error('VCGC Save Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Oops! Something went wrong while saving.');
        }
    }
}
