<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;

class RoleMiddleware
{
    /**
     * Map of URI patterns to required module permission keys.
     * The key is the route prefix or pattern.
     * The value is the module name assigned in manageRole.blade.php.
     */
    protected $routeModuleMap = [
        'admin/appointments' => 'appointments',
        'admin/doctors' => 'doctors',
        'admin/manage-doctor' => 'doctors',
        'admin/doctor-availability' => 'doctor_slots',
        'admin/manage-slot' => 'doctor_slots',
        'admin/patients' => 'patients',
        'admin/manage-patient' => 'patients',

        'admin/pharmacy' => 'pharmacy',
        'admin/manage-pharmacy' => 'pharmacy',
        'admin/store-locations' => 'stores',
        'admin/manage-store' => 'stores',

        'admin/medicine-type' => 'medicine',
        'admin/manage-medicine-type' => 'medicine',
        'admin/medicines' => 'medicine',
        'admin/manage-medicine' => 'medicine',
        'admin/medicine' => 'medicine',

        'admin/inventory' => 'inventory',

        'admin/suppliers' => 'suppliers',
        'admin/manage-supplier' => 'suppliers',
        'admin/orders' => 'orders',
        'admin/manage-order' => 'orders',

        'admin/billings' => 'billing',
        'admin/reports' => 'reports',

        'admin/users' => 'users',
        'admin/manage-user' => 'users',
        'admin/staff' => 'users',
        'admin/manage-staff' => 'users',

        'admin/settings' => 'settings',
        'admin/blood-groups' => 'listing',
        'admin/cities' => 'listing',
        'admin/clinics' => 'listing',
        'admin/degree' => 'listing',
        'admin/designation' => 'listing',
        'admin/facility' => 'listing',
        'admin/features' => 'listing',
        'admin/specialist' => 'listing',

        // Role Management specifically locked to Settings/Users
        'admin/roles' => 'settings',
        'admin/manage-role' => 'settings',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If not logged in, pass it to the 'auth' middleware
        if (!$user) {
            return $next($request);
        }

        // Master Admins (Role 1) implicitly bypass this for testing/failsafe unless features say otherwise,
        // but we'll strictly bind it to the Roles table to be completely database-driven.
        $roleInfo = Roles::find($user->role);

        if (!$roleInfo) {
            abort(403, 'Unauthorized Access - No Role Assigned');
        }

        $userPermissions = explode(',', $roleInfo->features ?? '');

        // 'All' keyword grants universal access
        if (in_array('All', $userPermissions)) {
            return $next($request);
        }

        $currentPath = $request->path();

        // Look for the required module for this specific path
        $requiredModule = null;
        foreach ($this->routeModuleMap as $pattern => $module) {
            // Using is() to allow exact matches or wildcard matches like 'admin/appointments/*'
            if ($request->is($pattern) || $request->is($pattern . '/*')) {
                $requiredModule = $module;
                break;
            }
        }

        // If a route is mapped to a module AND the user DOES NOT have that module in their permissions
        if ($requiredModule && !in_array($requiredModule, $userPermissions)) {
            // They are actively trying to access a restricted component
            abort(403, "Unauthorized Action. Your role lacks the '$requiredModule' permission component.");
        }

        // If the path isn't mapped (like the home dashboard or general ajax endpoints), let them through
        return $next($request);
    }
}
