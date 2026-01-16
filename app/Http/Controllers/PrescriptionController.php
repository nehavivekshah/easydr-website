<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    use Barryvdh\DomPDF\Facade\Pdf;
    
    use App\Models\Prescriptions;
    use App\Models\Prescription_medinices;
    use App\Models\Doctors;
    use App\Models\Patients;
    use App\Models\User;
    
    class PrescriptionController extends Controller
    {
        public function indexByPatient($patient_id)
        {
            $prescriptions = Prescriptions::leftjoin('users as pet','prescriptions.patient_id','pet.id')
                ->leftjoin('users as doc','prescriptions.doctor_id','doc.id')
                ->select('doc.first_name as doctor_first_name', 'doc.last_name as doctor_last_name', 'pet.first_name as patient_first_name', 'pet.last_name as patient_last_name', 'prescriptions.*')
                ->where('prescriptions.patient_id', '=', $patient_id)
                ->orderBy('prescriptions.created_at', 'desc')
                ->get();
        
            foreach ($prescriptions as $prescription) {
                $prescription->medicines = Prescription_medinices::where('prescribe_id', '=', $prescription->id)->get();
            }
        
            return response()->json(['data' => $prescriptions]);
        }

        public function indexByDoctor($doctor_id)
        {
            $prescriptions = Prescriptions::leftjoin('users as pet','prescriptions.patient_id','pet.id')
                ->select('pet.first_name as patient_first_name', 'pet.last_name as patient_last_name', 'prescriptions.*')
                ->where('prescriptions.doctor_id', '=', $doctor_id)
                ->orderBy('prescriptions.created_at', 'desc')
                ->get();
        
            foreach ($prescriptions as $prescription) {
                $prescription->medicines = Prescription_medinices::where('prescribe_id', '=', $prescription->id)->get();
            }
        
            return response()->json(['data' => $prescriptions]);
        }
        
        public function prescriptionPost(Request $request)
        {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'doctor_id'       => 'required|integer',
                'patient_id'      => 'required|integer',
                'prescribed_date' => 'required|date',
                'medicine_name'   => 'required|string|max:255',
                'dosage'          => 'required|string|max:255',
                'frequency'       => 'required|string|max:255',
                'duration'        => 'required|string|max:255',
                'route'           => 'nullable|string|max:255',
                'meal'            => 'nullable|string|max:255',
                'instruction'     => 'nullable|string',
                'notes'           => 'nullable|string',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
            $validated = $validator->validated();
        
            DB::beginTransaction();
        
            try {
                $prescription = null;
        
                // Attempt to retrieve an existing prescription for today
                $getPrescription = Prescriptions::where('doctor_id', $validated['doctor_id'])
                    ->where('patient_id', $validated['patient_id'])
                    ->whereDate('prescribed_date', today())
                    ->first();
        
                if (empty($request->prescribed_id)) {
                    // If no prescription ID is provided and no prescription exists for today, create one
                    if (!$getPrescription) {
                        $prescription = new Prescriptions();
                        $prescription->doctor_id = $validated['doctor_id'];
                        $prescription->patient_id = $validated['patient_id'];
                        $prescription->appointment_id = $request->appointment_id ?? null;
                        $prescription->prescribed_date = $validated['prescribed_date'];
                        $prescription->save();
                    } else {
                        $prescription = $getPrescription; // FIXED: Use model, not just the ID
                    }
                } else {
                    // If a prescription ID is provided, retrieve it or fail
                    $prescription = Prescriptions::findOrFail($request->prescribed_id);
                }
        
                // Create a new medicine entry linked to the prescription
                $prescriptionMedicine = new Prescription_medinices();
                $prescriptionMedicine->prescribe_id = $prescription->id;
                $prescriptionMedicine->medicine_name = $validated['medicine_name'];
                $prescriptionMedicine->dosage = $validated['dosage'];
                $prescriptionMedicine->frequency = $validated['frequency'];
                $prescriptionMedicine->duration = $validated['duration'];
                $prescriptionMedicine->route = $validated['route'] ?? null;
                $prescriptionMedicine->meal = $validated['meal'] ?? null;
                $prescriptionMedicine->instruction = $validated['instruction'] ?? null;
                $prescriptionMedicine->notes = $validated['notes'] ?? null;
                $prescriptionMedicine->save();
        
                DB::commit();
        
                return response()->json([
                    'message' => 'Prescription created successfully.',
                    'data' => $prescription
                ], 201);
            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Failed to create prescription.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        public function prescriptionMedicinePut($id, Request $request)
        {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'doctor_id'       => 'required|integer',
                'patient_id'      => 'required|integer',
                'prescribed_date' => 'required|date',
                'medicine_name'   => 'required|string|max:255',
                'dosage'          => 'required|string|max:255',
                'frequency'       => 'required|string|max:255',
                'duration'        => 'required|string|max:255',
                'route'           => 'nullable|string|max:255',
                'meal'            => 'nullable|string|max:255',
                'instruction'     => 'nullable|string',
                'notes'           => 'nullable|string',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
            // Extract validated data
            $validated = $validator->validated();
        
            // Try to find existing record by ID
            $prescriptionMedicine = Prescription_medinices::find($id);
        
            // If not found, create a new one if matching prescription exists
            if (!$prescriptionMedicine) {
                $prescription = Prescriptions::where('doctor_id', $validated['doctor_id'])
                    ->where('patient_id', $validated['patient_id'])
                    ->whereDate('prescribed_date', $validated['prescribed_date'])
                    ->first();
        
                if (!$prescription) {
                    return response()->json([
                        'message' => 'Matching prescription not found to associate new medicine.',
                        'data' => null
                    ], 404);
                }
        
                $prescriptionMedicine = new Prescription_medinices();
                $prescriptionMedicine->prescribe_id = $prescription->id;
            }
        
            // Set or update medicine data
            $prescriptionMedicine->medicine_name = $validated['medicine_name'];
            $prescriptionMedicine->dosage = $validated['dosage'];
            $prescriptionMedicine->frequency = $validated['frequency'];
            $prescriptionMedicine->duration = $validated['duration'];
            $prescriptionMedicine->route = $validated['route'] ?? null;
            $prescriptionMedicine->meal = $validated['meal'] ?? null;
            $prescriptionMedicine->instruction = $validated['instruction'] ?? null;
            $prescriptionMedicine->notes = $validated['notes'] ?? null;
        
            $prescriptionMedicine->save();
        
            return response()->json([
                'message' => 'Prescription medicine saved successfully.',
                'data' => $prescriptionMedicine
            ], 200);
        }

        public function prescriptionMedicineDelete($id)
        {
            // Find the record by ID
            $prescription = Prescription_medinices::find($id);  // Use the correct model name
            
            // Check if the record exists
            if ($prescription) {
                // Perform the deletion
                $prescription->delete();
        
                return response()->json([
                    'message' => 'Prescription medicine deleted successfully.',
                    'data' => null
                ], 200);  // Use 200 for successful requests
            }
        
            return response()->json([
                'message' => 'Prescription medicine not found.',
                'data' => null
            ], 404);  // Return 404 if the resource was not found
        }

        public function show(Prescription $prescription)
        {
            // Optional: Authorization
            $prescription->load('patient:id,first_name,last_name');
            return response()->json(['data' => $prescription]);
        }
        
        public function downloadPrescription($id)
        {
            $prescription = Prescriptions::findOrFail($id);
            $medicines = Prescription_medinices::where('prescribe_id', $id)->get();
            $doctor = Doctors::where('id', $prescription->doctor_id)->with('user')->first();
            $patient = Patients::where('id', $prescription->patient_id)->with('user')->first();
        
            $pdf = Pdf::loadView('prescriptions.download', compact('prescription', 'medicines', 'doctor', 'patient'));
        
            return $pdf->download("prescription_{$id}.pdf");
        }
    }
    
?>