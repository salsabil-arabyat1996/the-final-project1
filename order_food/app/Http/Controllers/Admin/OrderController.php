<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
         // Get the current date in the 'Y-m-d' format
        $todayDate = Carbon::now()->format('Y-m-d');
         // Query orders based on filters provided in the request
        $orders = Order::where(function ($q) use ($request, $todayDate) {

            // If a date is provided in the request, filter orders by that date
          if ($request->date) {
                $q->whereDate('created_at', $request->date);
            } else {
         // Otherwise, filter orders by the current date
                $q->whereDate('created_at', $todayDate);
            }
        // If a status is provided in the request, filter orders by that status
            if ($request->status) {
                $q->where('status_message', $request->status);
            }
        })->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $orderId)
    {

    // "بحث"Find the order with the given $orderId""
        $order = Order::find($orderId);

        if ($order) {
            return view('admin.orders.view', compact('order'));
        } else {
            return redirect('admin/orders')->with('message', 'Order Id not found');
        }
    }

    public function updateOrderStatus(int $orderId, Request $request)
    {
            // Find the order with the provided $orderId
    $order = Order::where('id', $orderId)->first();
       // Check if the order exists
     if($order) {

// If the order exists, update its status with the provided order_status
    $order->update([
    'status_message' => $request->order_status
    ]);

     // Redirect back to the order details page with a success message
    return redirect('admin/orders/'.$orderId)->with('message', 'Order Status Updated');
}
    else{

    // If the order doesn't exist, redirect back to the orders list with a message

    return redirect('admin/orders/'.$orderId)->with('message', 'Order Id not found');


    }}
    public function store(Request $request)
    {
         // Validate the incoming request data
        $validatedData = $request->validate([
            'tracking_no' => 'required',
        ]);
   // Create a new Order instance
        $order = new Order();
         // Set the tracking number for the order
        $order->tracking_no = $validatedData['tracking_no'];
        $order->save();

        return redirect()->route('admin.orders.index')->with('message', 'Order added successfully.');
    }
}
