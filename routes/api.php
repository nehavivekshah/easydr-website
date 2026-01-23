<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*Route::get('/test', function () {
    return response()->json('hello');
});*/

// Route for fetching available slots (matches frontend request /api/doctor/{id}/available-slots)
Route::get('/doctor/{id}/available-slots', [DoctorController::class, 'availableSlots']);

Route::prefix('/v1')->group(function () {
    //User list display, edit, insert router
    Route::apiResource('users', UserController::class);
    Route::post('/changePhoto/{id}', [UserController::class, 'changePhoto']);
    Route::get('/medical-reports/{id}', [UserController::class, 'medicalReports']);

    //App User account login/logout router
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //App Account forgot-password/verify-otp router
    Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

    //Doctor's Speslists Lists
    Route::get('/specialists', [DoctorController::class, 'specialists']);
    Route::get('/doctor-board/{id}', [DoctorController::class, 'doctorBoard']);

    //Doctor's Lists
    Route::get('/doctors', [DoctorController::class, 'doctors']);
    Route::get('/wallet/{id}', [DoctorController::class, 'wallet']);
    Route::get('/wallet-history/{id}', [DoctorController::class, 'walletHistory']);
    Route::get('/doctor/{id}', [DoctorController::class, 'doctor']);
    Route::post('/doctor/{id}', [DoctorController::class, 'doctorPost']);
    Route::get('/doctor-available/{id}', [DoctorController::class, 'doctorAvailable']);

    //Medicine's Lists
    Route::get('/medicines', [DoctorController::class, 'medicines']);
    Route::get('/medicines/{id}', [DoctorController::class, 'medicines']);
    Route::get('/medicine/{id}', [DoctorController::class, 'medicine']);

    // Fetch Medicines (matches: medicines/$currentUserId)
    Route::get('/carts/{uid}', [DoctorController::class, 'getCart']);
    Route::post('/add-to-cart', [DoctorController::class, 'addToCart']);
    Route::post('/update-cart', [DoctorController::class, 'updateCartQuantity']);
    Route::delete('/carts/{id}', [DoctorController::class, 'removeFromCart']);
    Route::post('/place-order', [DoctorController::class, 'placeOrder']);

    //Doctor's Availablity Slod Lists
    Route::get('/slots/{id}', [DoctorController::class, 'slots']);
    Route::post('/manage-slot', [DoctorController::class, 'manageSlot']);

    //Appointment's Lists
    Route::get('/appointments/{id}/{did?}', [DoctorController::class, 'appointments']);
    Route::get('/appointments-overview/{id}', [DoctorController::class, 'appointmentsOverview']);
    Route::post('/appointment-submit', [DoctorController::class, 'appointmentPost']);
    Route::post('/appointment-complete', [DoctorController::class, 'appointmentCompletePost']);
    Route::post('/appointments/cancel/{id}', [DoctorController::class, 'cancelAppointment']);

    // NEW: Endpoint for Flutter to get the list of active gateways
    Route::get('/payment-gateways', [DoctorController::class, 'getPaymentGateways']);
    Route::post('/appointment-submit', [DoctorController::class, 'appointmentPost']);
    Route::post('/appointment-verify', [DoctorController::class, 'verifyPaymentAndBook']);

    //Patients History Api
    Route::get('/patients/{id}', [DoctorController::class, 'patients']); //View Doctor's patients
    Route::get('/patient-details/{patientId}/{doctorId}', [DoctorController::class, 'patientDetails']);
    Route::get('/my-doctors', [DoctorController::class, 'myDoctors']);

    //chats api
    Route::get('/chats/{id}/{did}/{aid?}', [DoctorController::class, 'chats']);
    Route::post('/chats/{id}/{did}/{aid}', [DoctorController::class, 'chatPost']);

    //Wishlist doctors Api
    Route::get('/wishlists/{id}', [DoctorController::class, 'wishlists']);
    Route::post('/wishlist/{id}/{did}', [DoctorController::class, 'wishlistPost']);

    //Doctor revenue payment-history
    Route::get('/revenue/{id}', [DoctorController::class, 'revenue']);
    Route::get('/payment-history/{id}', [DoctorController::class, 'paymentHistory']);

    // Get prescriptions for a specific patient
    Route::get('/prescriptions/patient/{patient_id}', [PrescriptionController::class, 'indexByPatient']);
    Route::get('/prescriptions/{doctor_id}', [PrescriptionController::class, 'indexByDoctor']);

    // Store a new prescription (assuming doctor is authenticated)
    // Matches: POST /api/v1/prescriptions
    Route::post('/prescriptions', [PrescriptionController::class, 'prescriptionPost']);
    Route::post('/prescription-medicine', [PrescriptionController::class, 'prescriptionPost']);
    Route::put('/prescription-medicine/{id}', [PrescriptionController::class, 'prescriptionMedicinePut']);
    Route::delete('/prescription-medicine/{id}', [PrescriptionController::class, 'prescriptionMedicineDelete']);

    Route::get('/download-prescription/{id}', [PrescriptionController::class, 'downloadPrescription']);

    // You might also want:
    // Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show']);
    // Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->middleware('auth:sanctum');
    // Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->middleware('auth:sanctum');

    //Tag's Lists
    Route::get('/get-payment-gateway-configs', [PageController::class, 'paymentGatewayConfigs']);
    Route::get('/get-video-call-gateway-configs', [PageController::class, 'videoCallGatewayConfigs']);
    Route::get('/get-dosages', [PageController::class, 'getDosages']);
    Route::get('/get-frequencies', [PageController::class, 'getFrequencies']);
    Route::get('/get-durations', [PageController::class, 'getDurations']);
    Route::get('/get-routes', [PageController::class, 'getRoutes']);
    Route::get('/get-meals', [PageController::class, 'getMeals']);
    Route::get('/get-cities', [PageController::class, 'getCities']);
    Route::get('/get-states', [PageController::class, 'getStates']);
    Route::get('/get-countries', [PageController::class, 'getCountries']);

    //App Details Api
    Route::get('/page/{id}', [PageController::class, 'pageContent']);
    Route::get('/notifications', [PageController::class, 'notifications']);
});
