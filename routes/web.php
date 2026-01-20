<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebHomeController;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\WebPaymentController;
use App\Http\Controllers\WebAppointmentController;
use App\Http\Controllers\WebDoctorController;
use App\Http\Controllers\WebPharmacyController;
use App\Http\Controllers\WebReportController;
use App\Http\Controllers\WebTagsListingController;

/* Website Router */
Route::get('/', [FrontendController::class, 'index']);

/*Website signup/login pages*/
Route::get('/login', [FrontendController::class, 'login']);
Route::post('/login', [FrontendController::class, 'loginPost'])->name('login');
Route::get('/signup', [FrontendController::class, 'signup']);
Route::post('/signup', [FrontendController::class, 'signupPost'])->name('signup');
Route::get('/otp', [FrontendController::class, 'otp']);
Route::post('/verify-otp', [FrontendController::class, 'verifyOtp'])->name('otp');
Route::get('/forgot-password', [FrontendController::class, 'forgotPassword']);
Route::post('/forgot-password', [FrontendController::class, 'forgotPasswordPost'])->name('forgotPassword');
Route::get('/create-new-password', [FrontendController::class, 'createNewPassword']);
Route::post('/create-new-password', [FrontendController::class, 'createNewPasswordPost']);

/*Website My Account Pages*/
Route::get('/logout', [FrontendController::class, 'logout']);
Route::get('/my-account', [FrontendController::class, 'myAccount']);
Route::get('/my-profile', [FrontendController::class, 'myProfile']);
Route::get('/appointments', [FrontendController::class, 'appointments']);
Route::post('/cancel-appointment/{id}', [FrontendController::class, 'cancelAppointment'])->name('cancelAppointment');
Route::get('/manage-appointment', [FrontendController::class, 'manageAppointment']);

/*Website Informative Pages*/
;
Route::get('/patients', [FrontendController::class, 'patients']);
Route::get('/doctors', [FrontendController::class, 'doctors']);
Route::get('/doctors/{specialty}', [FrontendController::class, 'doctors']);
Route::get('/doctor/{id}/{token}', [FrontendController::class, 'doctorDetails']);
Route::get('/specialists', [FrontendController::class, 'specialists']);
Route::get('/pharmacy', [FrontendController::class, 'pharmacy']);
Route::get('/career', [FrontendController::class, 'career']);
Route::get('/health-tips', [FrontendController::class, 'healthTips']);
Route::get('/data-security', [FrontendController::class, 'dataSecurity']);
Route::get('/help', [FrontendController::class, 'contact']);

Route::get('/about-us', [FrontendController::class, 'about']);
Route::get('/services', [FrontendController::class, 'service']);
Route::get('/departments', [FrontendController::class, 'department']);
Route::get('/blog', [FrontendController::class, 'blog']);
Route::get('/contact-us', [FrontendController::class, 'contact']);
Route::post('/contact-us', [FrontendController::class, 'contactPost']);
Route::get('/help', [FrontendController::class, 'help']);
Route::post('/appointment', [FrontendController::class, 'bookAppointment']);

// Payment Routes
Route::get('/payment', [WebPaymentController::class, 'payment'])->name('payment');
Route::get('/payment/success', [WebPaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [WebPaymentController::class, 'paymentCancel'])->name('payment.cancel');

/* Dashboard Login / regiter routers */
Route::group(['middleware' => 'guest'], function () {
    Route::get('/admin/register', [WebAuthController::class, 'register'])->name('register');
    Route::post('/admin/register', [WebAuthController::class, 'registerPost'])->name('register');
    Route::get('/admin', [WebAuthController::class, 'login'])->name('login');
    Route::get('/admin/login', [WebAuthController::class, 'login'])->name('login');
    Route::post('/admin/login', [WebAuthController::class, 'loginPost'])->name('login');
});

/* Dashboard access routers */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin', [WebHomeController::class, 'home']);
    Route::get('/admin/home', [WebHomeController::class, 'home']);

    /*Pharmacy Management Router*/
    Route::get('/admin/pharmacy', [WebPharmacyController::class, 'pharmacy']);
    Route::get('/admin/manage-pharmacy', [WebPharmacyController::class, 'managePharmacy'])->name('managePharmacy');
    Route::post('/admin/manage-pharmacy', [WebPharmacyController::class, 'managePharmacyPost'])->name('managePharmacy');
    Route::delete('/admin/pharmacy/{id}', [WebPharmacyController::class, 'destroyPharmacy'])->name('pharmacy.destroy');

    /*Store Management Router*/
    Route::get('/admin/store-locations', [WebPharmacyController::class, 'stores']);
    Route::get('/admin/manage-store', [WebPharmacyController::class, 'manageStore'])->name('manageStore');
    Route::post('/admin/manage-store', [WebPharmacyController::class, 'manageStorePost'])->name('manageStore');
    Route::delete('/admin/stores/{id}', [WebPharmacyController::class, 'destroyStore'])->name('stores.destroy');

    /*Medicine Type Management Router*/
    Route::get('/admin/medicine-type', [WebPharmacyController::class, 'medicineTypes'])->name('medicineTypes');
    Route::get('/admin/manage-medicine-type', [WebPharmacyController::class, 'manageMedicineType'])->name('manageMedicineType');
    Route::post('/admin/manage-medicine-type', [WebPharmacyController::class, 'manageMedicineTypePost'])->name('manageMedicineType');
    Route::delete('/admin/medicine-type/{id}', [WebPharmacyController::class, 'destroyMedicineType'])->name('medicineType.destroy');

    /*Medicine Management Router*/
    Route::get('/get-locations/{pharmacyId}', [WebPharmacyController::class, 'getLocations']);
    Route::get('/admin/medicine-listings', [WebPharmacyController::class, 'medicines'])->name('medicines');
    Route::get('/admin/manage-medicine', [WebPharmacyController::class, 'manageMedicine'])->name('manageMedicine');
    Route::post('/admin/manage-medicine', [WebPharmacyController::class, 'manageMedicinePost'])->name('manageMedicine');
    Route::delete('/admin/medicine/{id}', [WebPharmacyController::class, 'destroyMedicine'])->name('medicine.destroy');

    Route::get('/admin/inventory/{store_id}', [WebPharmacyController::class, 'inventory'])->name('inventory.index');
    Route::get('/admin/suppliers', [WebPharmacyController::class, 'suppliers'])->name('suppliers.index');
    Route::get('/admin/orders', [WebPharmacyController::class, 'orders'])->name('orders.index');
    Route::get('/admin/billing', [WebPharmacyController::class, 'billing'])->name('billing.index');
    Route::get('/admin/reports', [WebPharmacyController::class, 'reports'])->name('reports.index');

    /* POST Routes for Pharmacy Management */
    /* POST Routes for Pharmacy Management */
    Route::post('/admin/inventory/update', [WebPharmacyController::class, 'updateInventory'])->name('inventory.update');
    Route::get('/admin/inventory/edit/{id}', [WebPharmacyController::class, 'editInventory']);
    Route::get('/admin/inventory/delete/{id}', [WebPharmacyController::class, 'deleteInventory'])->name('inventory.delete');

    Route::post('/admin/suppliers/add', [WebPharmacyController::class, 'addSupplier'])->name('suppliers.add');
    Route::get('/admin/suppliers/edit/{id}', [WebPharmacyController::class, 'editSupplier']);
    Route::get('/admin/suppliers/delete/{id}', [WebPharmacyController::class, 'deleteSupplier'])->name('suppliers.delete');

    Route::post('/admin/orders/place', [WebPharmacyController::class, 'placeOrder'])->name('orders.place');
    Route::get('/admin/orders/edit/{id}', [WebPharmacyController::class, 'editOrder']);
    Route::get('/admin/orders/delete/{id}', [WebPharmacyController::class, 'deleteOrder'])->name('orders.delete');

    Route::post('/admin/billing/process', [WebPharmacyController::class, 'processPayment'])->name('billing.process');
    Route::get('/admin/billing/edit/{id}', [WebPharmacyController::class, 'editBilling']);
    Route::get('/admin/billing/delete/{id}', [WebPharmacyController::class, 'deleteBilling'])->name('billing.delete');

    Route::post('/admin/reports/generate', [WebPharmacyController::class, 'generateReport'])->name('reports.generate');
    Route::get('/admin/reports/delete/{id}', [WebPharmacyController::class, 'deleteReport'])->name('reports.delete');

    /*Appointments Management Router*/
    Route::get('/admin/upcoming-appointments', [WebAppointmentController::class, 'upcomingAppointments']);
    Route::get('/admin/appointment-history', [WebAppointmentController::class, 'appointmentHistory']);
    Route::get('/admin/appointment-calendar', [WebAppointmentController::class, 'appointmentCalendar']);
    Route::get('/admin/manage-appointment', [WebAppointmentController::class, 'manageAppointment'])->name('manageAppointment');
    Route::post('/admin/manage-appointment', [WebAppointmentController::class, 'manageAppointmentPost'])->name('manageAppointment');
    Route::post('/admin/cancel-appointment/{appointmentId}', [WebAppointmentController::class, 'cancelAppointmentPost']);
    Route::get('/admin/get-doctor-availability/{doctorId}', [WebAppointmentController::class, 'getDoctorAvailability']);

    /*Doctors Availability Slots*/
    Route::get('/admin/doctor-appointment-history', [WebAppointmentController::class, 'appointmentHistory']);
    Route::get('/admin/assigned-doctors', [WebDoctorController::class, 'assignedDoctors']);
    Route::get('/admin/doctor-availability', [WebDoctorController::class, 'doctorAvailability']);
    Route::get('/admin/manage-slot', [WebDoctorController::class, 'manageSlot']);
    Route::post('/admin/manage-slot', [WebDoctorController::class, 'manageSlotPost'])->name('manageSlot');

    /*patients Availability Slots*/
    Route::get('/admin/patient-appointment-history', [WebAppointmentController::class, 'appointmentHistory']);

    /*User's Account Management Router*/
    Route::get('/admin/users/{type}', [WebUserController::class, 'users']);
    Route::get('/admin/manage-user/{type}', [WebUserController::class, 'manageNewUser'])->name('manageNewUser');
    Route::get('/admin/manage-user/{type}/{id}', [WebUserController::class, 'manageUser'])->name('manageUser');
    Route::post('/admin/manage-user', [WebUserController::class, 'manageUserPost'])->name('manageUser');
    Route::get('/admin/users/delete/{id}', [WebUserController::class, 'deleteUser'])->name('deleteUser');

    /*patient-health-card Management Router*/
    Route::get('/admin/patient-health-card', [WebUserController::class, 'patientHealthCard'])->name('patientHealthCard');
    Route::post('/admin/patient-health-card', [WebUserController::class, 'verifyHealthCard'])->name('patientHealthCard');
    Route::get('/admin/patient-health-card/{id}/edit', [WebUserController::class, 'editPatientHealthCard'])->name('admin.patient.healthcard.edit');
    Route::post('/admin/patient-health-card/{id}/update', [WebUserController::class, 'updatePatientHealthCard'])->name('admin.patient.healthcard.update');

    /*My Profile Management Router*/
    Route::get('/admin/my-profile/{type}/{id}', [WebUserController::class, 'manageUser']);
    Route::post('/admin/my-profile', [WebUserController::class, 'manageUserPost'])->name('manageUser');

    Route::get('/admin/reset-password', [WebUserController::class, 'resetPassword']);
    Route::post('/admin/reset-password', [WebUserController::class, 'resetPasswordPost'])->name('resetPassword');

    /*User's Role Management Router*/
    Route::get('/admin/role-settings', [SettingController::class, 'roleSettings']);
    Route::get('/admin/manage-role-setting', [SettingController::class, 'manageRoleSettings'])->name('manageRoleSettings');
    Route::post('/admin/manage-role-setting', [SettingController::class, 'manageRoleSettingsPost'])->name('manageRoleSettings');

    /*Specialist Management Router*/
    Route::get('/admin/payment-gateway-configs', [SettingController::class, 'paymentGatewayConfigs']);
    Route::get('/admin/manage-payment-gateway-config', [SettingController::class, 'managePaymentGatewayConfig'])->name('managePaymentGatewayConfig');
    Route::post('/admin/manage-payment-gateway-config', [SettingController::class, 'managePaymentGatewayConfigPost'])->name('managePaymentGatewayConfig');

    /*Specialist Management Router*/
    Route::get('/admin/video-call-gateway-configs', [SettingController::class, 'videoCallGatewayConfigs']);
    Route::get('/admin/manage-video-call-gateway-config', [SettingController::class, 'manageVideoCallGatewayConfig'])->name('manageVideoCallGatewayConfig');
    Route::post('/admin/manage-video-call-gateway-config', [SettingController::class, 'manageVideoCallGatewayConfigPost'])->name('manageVideoCallGatewayConfig');

    /*Specialist Management Router*/
    Route::get('/admin/dosages', [WebTagsListingController::class, 'dosages']);
    Route::get('/admin/manage-dosage', [WebTagsListingController::class, 'manageDosage'])->name('manageDosage');
    Route::post('/admin/manage-dosage', [WebTagsListingController::class, 'manageDosagePost'])->name('manageDosage');

    /*Specialist Management Router*/
    Route::get('/admin/frequencies', [WebTagsListingController::class, 'frequencies']);
    Route::get('/admin/manage-frequency', [WebTagsListingController::class, 'manageFrequency'])->name('manageFrequency');
    Route::post('/admin/manage-frequency', [WebTagsListingController::class, 'manageFrequencyPost'])->name('manageFrequency');

    /*Durations Management Router*/
    Route::get('/admin/durations', [WebTagsListingController::class, 'durations']);
    Route::get('/admin/manage-duration', [WebTagsListingController::class, 'manageDuration'])->name('manageDuration');
    Route::post('/admin/manage-duration', [WebTagsListingController::class, 'manageDurationPost'])->name('manageDuration');

    /*Specialist Management Router*/
    Route::get('/admin/routes', [WebTagsListingController::class, 'routes']);
    Route::get('/admin/manage-route', [WebTagsListingController::class, 'manageRoute'])->name('manageRoute');
    Route::post('/admin/manage-route', [WebTagsListingController::class, 'manageRoutePost'])->name('manageRoute');

    /*Specialist Management Router*/
    Route::get('/admin/meals', [WebTagsListingController::class, 'meals']);
    Route::get('/admin/manage-meal', [WebTagsListingController::class, 'manageMeal'])->name('manageMeal');
    Route::post('/admin/manage-meal', [WebTagsListingController::class, 'manageMealPost'])->name('manageMeal');

    /*Pharmacy Types Management Router*/
    Route::get('/admin/pharmacy-types', [WebTagsListingController::class, 'pharmacyTypes']);
    Route::get('/admin/manage-pharmacy-type', [WebTagsListingController::class, 'managePharmacyType'])->name('managePharmacyType');
    Route::post('/admin/manage-pharmacy-type', [WebTagsListingController::class, 'managePharmacyTypePost'])->name('managePharmacyType');

    /*Specialist Management Router*/
    Route::get('/admin/specialists', [WebTagsListingController::class, 'specialists']);
    Route::get('/admin/manage-specialist', [WebTagsListingController::class, 'manageSpecialist'])->name('manageSpecialist');
    Route::post('/admin/manage-specialist', [WebTagsListingController::class, 'manageSpecialistPost'])->name('manageSpecialist');

    /*City Management Router*/
    Route::get('/admin/cities', [WebTagsListingController::class, 'cities']);
    Route::get('/admin/manage-city', [WebTagsListingController::class, 'manageCity'])->name('manageCity');
    Route::post('/admin/manage-city', [WebTagsListingController::class, 'manageCityPost'])->name('manageCity');

    /*State Management Router*/
    Route::get('/admin/states', [WebTagsListingController::class, 'states']);
    Route::get('/admin/manage-state', [WebTagsListingController::class, 'manageState'])->name('manageState');
    Route::post('/admin/manage-state', [WebTagsListingController::class, 'manageStatePost'])->name('manageState');

    /*Country Management Router*/
    Route::get('/admin/countries', [WebTagsListingController::class, 'countries']);
    Route::get('/admin/manage-country', [WebTagsListingController::class, 'manageCountry'])->name('manageCountry');
    Route::post('/admin/manage-country', [WebTagsListingController::class, 'manageCountryPost'])->name('manageCountry');

    /*Notifications Management Router*/
    Route::get('/admin/notification-settings', [WebTagsListingController::class, 'notificationSettings']);

    //Delete Router
    Route::get('/admin/delete-record', [WebTagsListingController::class, 'deleteRecord'])->name('delete.record');

    //Logout Router
    Route::delete('/admin/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/admin/logout', [WebAuthController::class, 'logout'])->name('logout');

    /* Analytical Reports */
    Route::get('/admin/patient-reports', [WebReportController::class, 'patientReports']);
    Route::get('/admin/patient-statistics', [WebReportController::class, 'patientStatistics']);
    Route::get('/admin/appointment-reports', [WebReportController::class, 'appointmentReports']);
    Route::get('/admin/revenue-reports', [WebReportController::class, 'revenueReports']);

});

Route::get('/test-email', function () {
    try {
        \Mail::raw('Hello from Laravel!', function ($message) {
            $message->to('iwebbrella@gmail.com')->subject('Test Email');
        });
        return 'Mail sent successfully!';
    } catch (\Exception $e) {
        \Log::error('Mail send error: ' . $e->getMessage());
        return 'Failed to send mail: ' . $e->getMessage();
    }
});

Route::get('/test-sms', function () {
    try {
        $sms = new \App\Services\SmsService();
        $result = $sms->send('+1234567890', 'Test SMS from Laravel');
        return $result ? 'SMS Sent' : 'SMS Failed (Check Logs)';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return 'DONE'; //Return anything
});
