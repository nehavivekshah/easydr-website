<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Carts;
use App\Models\Medicines;
use App\Models\Prescriptions;
use App\Models\Prescription_medinices;
use App\Models\Orders;
use App\Models\OrderItems;

class CartController extends Controller
{
    public function viewCart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = Carts::with('medicine')->where('user_id', $user->id)->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            if ($item->medicine) {
                // Assuming price is in medicine or we pull from a designated field.
                // Our schema might have 'price' or 'mrp' in Medicines table. Let's use 'mrp' or 'price'.
                $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                $subtotal += $price * $item->quantity;
            }
        }

        return view('frontend.cart', compact('cartItems', 'subtotal'));
    }

    public function addPrescription(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please login to add to cart.']);
        }

        $request->validate([
            'prescription_id' => 'required|integer'
        ]);

        $prescriptionId = $request->prescription_id;

        // Ensure prescription belongs to user
        $prescription = Prescriptions::where('id', $prescriptionId)->where('patient_id', $user->id)->first();
        if (!$prescription) {
            return redirect()->back()->with('error', 'Prescription not found or unauthorized.');
        }

        $prescribedMedicines = Prescription_medinices::where('prescribe_id', $prescriptionId)->get();

        $addedCount = 0;
        $notFoundItems = [];

        foreach ($prescribedMedicines as $pm) {
            // Attempt to find a matching medicine in catalog
            $medicine = Medicines::where('name', 'LIKE', '%' . $pm->medicine_name . '%')
                ->where('status', 1) // assuming 1 is active
                ->first();

            if ($medicine) {
                // Check if already in cart
                $cartItem = Carts::where('user_id', $user->id)
                    ->where('medicine_id', $medicine->id)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += 1;
                    $cartItem->save();
                } else {
                    Carts::create([
                        'user_id' => $user->id,
                        'medicine_id' => $medicine->id,
                        'quantity' => 1
                    ]);
                }
                $addedCount++;
            } else {
                $notFoundItems[] = $pm->medicine_name;
            }
        }

        $msg = "Added $addedCount prescribed medicines to your cart.";
        if (count($notFoundItems) > 0) {
            $msg .= " Some items (" . implode(', ', $notFoundItems) . ") were currently unavailable in our active catalog.";
            return redirect('/cart')->with('warning', $msg);
        }

        return redirect('/cart')->with('success', $msg);
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $request->validate([
            'cart_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Carts::where('id', $request->cart_id)->where('user_id', $user->id)->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return redirect()->back()->with('success', 'Cart updated.');
        }

        return redirect()->back()->with('error', 'Item not found in your cart.');
    }

    public function removeCart($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $cartItem = Carts::where('id', $id)->where('user_id', $user->id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found.');
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $cartItems = Carts::with('medicine')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
            $totalAmount += $price * $item->quantity;
        }

        DB::beginTransaction();

        try {
            // Create Order
            $order = Orders::create([
                'user_id' => $user->id,
                'status' => 0, // 0 = Pending
                'total_amount' => $totalAmount,
                // Defaults for address/store if necessary
                'store_id' => 0,
                'address' => 'Customer Registered Address'
            ]);

            // Create OrderItems
            foreach ($cartItems as $item) {
                $price = $item->medicine->price ?? $item->medicine->mrp ?? 0;
                OrderItems::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'price' => $price
                ]);
            }

            // Clear Cart
            Carts::where('user_id', $user->id)->delete();

            DB::commit();

            return view('frontend.checkout_success', compact('order'));

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect('/cart')->with('error', 'An error occurred during checkout: ' . $e->getMessage());
        }
    }
}
