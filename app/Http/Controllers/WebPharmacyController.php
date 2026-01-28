<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Models\PharmacyMaster;
use App\Models\Pharmacy_types;
use App\Models\Store_locations;
use App\Models\Medicines;
use App\Models\Medicine_types;
use App\Models\Inventory;
use App\Models\Suppliers;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Billings;
use App\Models\Reports;
use Carbon\Carbon;

class WebPharmacyController extends Controller
{
    // List All Pharmacy
    public function pharmacy()
    {
        $pharmacyMaster = PharmacyMaster::all();

        return view('pharmacy.index', compact('pharmacyMaster'));
    }

    // Create a New Store & Edit Store Details
    public function managePharmacy(Request $request)
    {
        $id = $request->id ?? '';
        $pharmacyMaster = PharmacyMaster::leftjoin('pharmacy_bank_details', 'pharmacy_masters.PharmacyID', '=', 'pharmacy_bank_details.pmId')
            ->select('pharmacy_masters.*', 'pharmacy_bank_details.*')
            ->where('pharmacy_masters.PharmacyID', '=', $id)->first();

        $pharmacy_types = Pharmacy_types::get();

        return view('pharmacy.managePharmacy', ['pharmacyMaster' => $pharmacyMaster, 'pharmacy_types' => $pharmacy_types]);
    }

    public function managePharmacyPost(Request $request)
    {
        $pharmacyId = $request->PharmacyID;

        $request->validate([
            'PharmacyCode' => 'required|string|max:255',
            'PharmacyName' => 'required|string|max:255',
            'PharmacyType' => 'required|string|max:255',
            'PrimaryContactName' => 'required|string|max:255',
            'Designation' => 'required|string|max:255',
            'MobileNumber' => 'required|string|max:50',
            'EmailAddress' => 'required|email|max:255',
            'Address' => 'required|string|max:255',
            'City' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'ZipCode' => 'required|string|max:50',
            'LicenseNumber' => 'required|string|max:255',
            'LicenseExpirationDate' => 'required|date',
        ]);

        $pharmacyData = $request->only([
            'PharmacyCode',
            'PharmacyName',
            'Address',
            'City',
            'State',
            'ZipCode',
            'PhoneNumber',
            'MobileNumber',
            'FaxNumber',
            'EmailAddress',
            'WebsiteURL',
            'NPI',
            'DEANumber',
            'LicenseNumber',
            'LicenseExpirationDate',
            'PharmacyType',
            'OwnershipType',
            'HoursOfOperation',
            'EmergencyServices',
            'ServicesOffered',
            'PrimaryContactName',
            'Designation',
            'TaxID'
        ]);

        // Extract bank data separately
        $bankData = $request->only([
            'BankName' => 'bankname',
            'BranchName' => 'branchname',
            'AccountType' => 'account_type',
            'AccountName' => 'account_name',
            'AccountNumber' => 'account_number',
            'AccountCode' => 'ifsccode',
            'AccountStatus' => 'status',
        ]);

        // Normalize keys
        $bankData = [
            'bankname' => $request->BankName,
            'branchname' => $request->BranchName,
            'account_type' => $request->AccountType,
            'account_name' => $request->AccountName,
            'account_number' => $request->AccountNumber,
            'ifsccode' => $request->AccountCode,
            'status' => $request->AccountStatus,
        ];

        if ($pharmacyId) {
            $store = PharmacyMaster::findOrFail($pharmacyId);
            $store->update($pharmacyData);

            // Update or create bank details
            $store->pharmacyBankDetails()->updateOrCreate(
                ['pmId' => $store->PharmacyID],
                $bankData
            );

            return back()->with('success', 'Pharmacy updated successfully.');
        } else {
            $store = PharmacyMaster::create($pharmacyData);

            // Create related bank details
            $store->pharmacyBankDetails()->create($bankData);

            return back()->with('success', 'Pharmacy added successfully.');
        }
    }

    // Delete Store
    public function destroyPharmacy($id)
    {
        $store = PharmacyMaster::find($id);

        if (!$store) {
            return back()->with('error', 'Store not found.');
        }

        $store->delete();

        return back()->with('success', 'Store deleted successfully.');
    }

    // List All Stores
    public function stores()
    {
        $stores = Store_locations::all();

        return view('pharmacy.storeLocations', compact('stores'));
    }

    // Create a New Store & Edit Store Details
    public function manageStore(Request $request)
    {
        $id = $request->id ?? '';
        $store = Store_locations::where('LocationID', '=', $id)->first();
        $pharmacyMasters = PharmacyMaster::get();

        return view('pharmacy.manageStore', ['store' => $store, 'pharmacyMasters' => $pharmacyMasters]);
    }

    public function manageStorePost(Request $request)
    {
        $id = $request->LocationID ?? null;

        // Validate Input Data
        $request->validate([
            'PharmacyID' => 'required',
            'LocationName' => 'required|string|max:255',
            'Address' => 'required|string|max:255',
            'City' => 'required|string|max:255',
            'State' => 'required|string|max:255',
            'ZipCode' => 'required|string|max:50',
            'MapLink' => 'nullable|string|max:500',
            'PhoneNumber' => 'required|string|max:20',
            'HoursOfOperation' => 'nullable|array|max:100',
            'ContactName' => 'nullable|string|max:255',
            'Designation' => 'nullable|string|max:255',
            'ContactEmail' => 'nullable|string|max:255',
            'SquareFootage' => 'nullable|string|max:100',
            'AccessibilityFeatures' => 'nullable|string',
        ]);

        // Data to Store LocationID Latitude Longitude status CreatedAt	UpdatedAt

        $data = $request->only([
            'PharmacyID',
            'LocationName',
            'Address',
            'City',
            'State',
            'ZipCode',
            'MapLink',
            'PhoneNumber',
            'HoursOfOperation',
            'ContactName',
            'Designation',
            'ContactEmail',
            'SquareFootage',
            'AccessibilityFeatures'
        ]);

        if ($id) {
            // UPDATE STORE
            $store = Store_locations::findOrFail($id);
            $store->update($data);
            return back()->with('success', 'Store updated successfully.');
        } else {
            // CREATE STORE
            Store_locations::create($data);
            return back()->with('success', 'Store added successfully.');
        }
    }

    // Delete Store
    public function destroyStore($id)
    {
        $store = Store_locations::find($id);

        if (!$store) {
            return back()->with('error', 'Store not found.');
        }

        $store->delete();

        return back()->with('success', 'Store deleted successfully.');
    }

    // ========================= Medicine Management =========================

    // List Medicine Type by Store
    public function medicineTypes(Request $request)
    {
        $types = Medicine_types::all();

        return view('pharmacy.medicineTypes', compact('types'));
    }

    // Add & Edit Medicine Type 
    public function manageMedicineType(Request $request)
    {
        $id = $request->id ?? '';
        $types = Medicine_types::where('id', '=', $id)->first();

        return view('pharmacy.manageMedicineType', compact('types'));
    }

    public function manageMedicineTypePost(Request $request)
    {
        $id = $request->id ?? null;

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'name'
        ]);

        if ($id) {
            // UPDATE STORE
            $medicineType = Medicine_types::findOrFail($id);
            $medicineType->update($data);
            return back()->with('success', 'Medicine Type updated successfully.');
        } else {
            // CREATE STORE
            Medicine_types::create($data);
            return back()->with('success', 'Medicine Type added successfully.');
        }
    }

    // Delete Store
    public function destroyMedicineType($id)
    {
        $medicine_type = Medicine_types::find($id);

        if (!$medicine_type) {
            return back()->with('error', 'Medicine type not found.');
        }

        $medicine_type->delete();

        return back()->with('success', 'Medicine type deleted successfully.');
    }

    // 5. List Medicines by Store
    public function medicines(Request $request)
    {
        $PharmacyID = $request->PharmacyID ?? '';
        $StoreId = $request->storeid ?? '';

        if (!empty($PharmacyID)) {
            $medicines = Medicines::where('pharmacy_id', $PharmacyID)->get();
        } elseif (!empty($StoreId)) {
            $medicines = Medicines::where('store_id', $StoreId)->get();
        } else {
            $medicines = Medicines::leftjoin('medicine_types', 'medicines.type_id', '=', 'medicine_types.id')
                ->select('medicine_types.name as type_name', 'medicines.*')->get();
        }

        return view('pharmacy.medicines', compact('medicines'));
    }

    public function manageMedicine(Request $request)
    {
        $id = $request->id ?? '';
        $medicine = Medicines::where('id', $id)->first();
        $types = Medicine_types::all();
        $stores = PharmacyMaster::all();
        $locations = Store_locations::where('PharmacyID', '=', ($medicine->pharmacy_id ?? ''))->get();

        return view('pharmacy.manageMedicine', compact('medicine', 'types', 'stores', 'locations'));
    }

    // 6. Add Medicine
    public function manageMedicinePost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'store_id' => 'required|integer',
            'store_locations' => 'required|array',
            'medical_stream' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'discount_cost' => 'nullable|numeric',
            'available' => 'required|boolean',
            'label' => 'nullable|string|max:255',
            'type_id' => 'required|integer',
            'medicine_category' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date|after_or_equal:today',
        ]);

        if ($request->id) {
            // Update existing medicine
            $medicine = Medicines::find($request->id);
            if (!$medicine) {
                return back()->with('error', 'Medicine not found.');
            }
        } else {
            // Insert new medicine
            $medicine = new Medicines();
        }

        $medicine->branch = $request->branch ?? '1';
        $medicine->pharmacy_id = $request->store_id;
        $medicine->name = $request->name;
        $medicine->store_id = implode(',', ($request->store_locations ?? []));
        $medicine->medical_stream = $request->medical_stream;
        $medicine->cost = $request->cost;
        $medicine->discount_cost = $request->discount_cost;
        $medicine->available = $request->available;
        $medicine->label = $request->label;
        $medicine->type_id = $request->type_id;
        $medicine->medicine_category = $request->medicine_category;
        $medicine->purpose = $request->purpose;
        $medicine->symptoms = $request->symptoms;
        $medicine->description = $request->description;
        $medicine->stock_quantity = $request->stock_quantity ?? 0;
        $medicine->expiration_date = $request->expiry_date;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('assets/images/medicines'), $thumbnailName);
            $medicine->img = 'assets/images/medicines/' . $thumbnailName; // Relative path
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/images/medicines'), $imageName);
                $imagePaths[] = 'assets/images/medicines/' . $imageName;
            }
            $medicine->gallery = json_encode($imagePaths);
        }

        $medicine->save();

        return redirect()->route('medicines')->with('success', 'Medicine saved successfully.');
    }

    // Delete Store
    public function destroyMedicine($id)
    {
        $medicine_type = Medicines::find($id);

        if (!$medicine_type) {
            return back()->with('error', 'Medicine not found.');
        }

        $medicine_type->delete();

        return back()->with('success', 'Medicine deleted successfully.');
    }

    public function getLocations($pharmacyId)
    {
        $locations = Store_locations::where('PharmacyID', $pharmacyId)->get();
        return response()->json($locations);
    }

    // ========================= Inventory Management =========================

    // List Inventory (Store specific)
    public function inventory($store_id)
    {
        $inventory = Inventory::where('store_id', $store_id)->get();
        return view('admin.inventory.index', compact('inventory', 'store_id'));
    }

    // Edit Inventory
    public function editInventory($id)
    {
        $inventory = Inventory::find($id);
        return response()->json($inventory);
    }

    // Update Inventory Stock
    public function updateInventory(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|integer',
            'store_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        if ($request->id) {
            $inventory = Inventory::find($request->id);
            $inventory->quantity = $request->quantity;
            $inventory->save();
        } else {
            Inventory::updateOrCreate(
                ['medicine_id' => $request->medicine_id, 'store_id' => $request->store_id],
                ['quantity' => $request->quantity]
            );
        }

        return back()->with('success', 'Inventory updated successfully.');
    }

    // Delete Inventory Item
    public function deleteInventory($id)
    {
        $inventory = Inventory::find($id);
        if ($inventory) {
            $inventory->delete();
            return back()->with('success', 'Inventory item deleted successfully.');
        }
        return back()->with('error', 'Item not found.');
    }

    // ========================= Supplier Management =========================

    // 9. List Suppliers
    public function suppliers()
    {
        $suppliers = Suppliers::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    // 10. Add/Update Supplier
    public function addSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|email' . ($request->id ? '' : '|unique:suppliers,email'),
            'address' => 'required|string',
        ]);

        if ($request->id) {
            $supplier = Suppliers::find($request->id);
            $supplier->update($request->all());
            return back()->with('success', 'Supplier updated successfully.');
        } else {
            Suppliers::create($request->all());
            return back()->with('success', 'Supplier added successfully.');
        }
    }

    // Edit Supplier
    public function editSupplier($id)
    {
        $supplier = Suppliers::find($id);
        return response()->json($supplier);
    }

    // Delete Supplier
    public function deleteSupplier($id)
    {
        $supplier = Suppliers::find($id);
        if ($supplier) {
            $supplier->delete();
            return back()->with('success', 'Supplier deleted successfully.');
        }
        return back()->with('error', 'Supplier not found.');
    }

    // ========================= Order Management =========================

    // 11. List Orders
    public function orders()
    {
        $orders = Orders::with('items')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Manage Order (Create/Edit View)
    public function manageOrder(Request $request)
    {
        $id = $request->id;
        $order = null;
        if ($id) {
            $order = Orders::with('items')->find($id);
        }

        $stores = Store_locations::all();
        $suppliers = Suppliers::all();
        $medicines = Medicines::all();

        return view('admin.orders.manageOrder', compact('order', 'stores', 'suppliers', 'medicines'));
    }

    // 12. Place/Update Order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'store_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'order_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.medicine_id' => 'required|array',
            'items.quantity' => 'required|array',
            'items.price' => 'required|array',
        ]);

        try {
            \DB::transaction(function () use ($request) {

                $data = [
                    'user_id' => Auth::id() ?? 1, // Fallback to 1 if not auth (should be auth)
                    'store_id' => $request->store_id,
                    'supplier_id' => $request->supplier_id,
                    'order_date' => $request->order_date,
                    'status' => $request->status,
                    'shipping_address' => $request->shipping_address ?? '',
                    'total_amount' => $request->total_amount,
                ];

                if ($request->id) {
                    $order = Orders::find($request->id);
                    $order->update($data);
                    // Clear existing items to rewrite (simpler than syncing for now)
                    OrderItems::where('order_id', $order->id)->delete();
                } else {
                    $order = Orders::create($data);
                }

                // Save Items
                $items = $request->items;
                for ($i = 0; $i < count($items['medicine_id']); $i++) {
                    if (!empty($items['medicine_id'][$i])) {
                        OrderItems::create([
                            'order_id' => $order->id,
                            'medicine_id' => $items['medicine_id'][$i],
                            'quantity' => $items['quantity'][$i],
                            'price' => $items['price'][$i],
                        ]);
                    }
                }
            });

            return redirect()->route('orders.index')->with('success', 'Order saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save order: ' . $e->getMessage())->withInput();
        }
    }

    // Edit Order (JSON - Deprecated but kept for backward compatibility if needed)
    public function editOrder($id)
    {
        $order = Orders::with('items')->find($id);
        return response()->json($order);
    }

    // Delete Order
    public function deleteOrder($id)
    {
        $order = Orders::find($id);
        if ($order) {
            $order->delete();
            return back()->with('success', 'Order deleted successfully.');
        }
        return back()->with('error', 'Order not found.');
    }

    // ========================= Billing Management =========================

    // 13. Get Billing Details
    public function billing()
    {
        $billings = Billings::all();
        return view('admin.billing.index', compact('billings'));
    }

    // 14. Process/Update Payment
    public function processPayment(Request $request)
    {
        $request->validate([
            'store_id' => 'required|integer',
            'order_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|in:Paid,Pending,Failed',
        ]);

        if ($request->id) {
            $billing = Billings::find($request->id);
            $billing->update($request->all());
            return back()->with('success', 'Payment details updated successfully.');
        } else {
            Billings::create($request->all());
            return back()->with('success', 'Payment processed successfully.');
        }
    }

    // Edit Billing
    public function editBilling($id)
    {
        $billing = Billings::find($id);
        return response()->json($billing);
    }

    // Delete Billing
    public function deleteBilling($id)
    {
        $billing = Billings::find($id);
        if ($billing) {
            $billing->delete();
            return back()->with('success', 'Billing record deleted successfully.');
        }
        return back()->with('error', 'Record not found.');
    }

    // ========================= Reports =========================

    // 15. Generate Reports
    public function reports()
    {
        try {
            $reports = Reports::latest()->get();
        } catch (\Exception $e) {
            $reports = collect([]);
        }
        return view('admin.reports.index', compact('reports'));
    }

    // 16. Generate Store Report
    public function generateReport(Request $request)
    {
        $request->validate([
            'store_id' => 'required|integer',
            'report_type' => 'required|in:Sales,Inventory,Orders,Revenue',
            'details' => 'required|string',
        ]);

        if ($request->id) {
            // Report updates usually not standard but implemented for consistency
            $report = Reports::find($request->id);
            $report->update($request->all());
            return back()->with('success', 'Report updated successfully.');
        } else {
            Reports::create($request->all());
            return back()->with('success', 'Report generated successfully.');
        }
    }

    // Delete Report
    public function deleteReport($id)
    {
        $report = Reports::find($id);
        if ($report) {
            $report->delete();
            return back()->with('success', 'Report deleted successfully.');
        }
        return back()->with('error', 'Report not found.');
    }
}

?>