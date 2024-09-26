<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Customer $customer)
    {
       
        $orders = $customer->orders()
            ->join('order_statuses', 'orders.status', '=', 'order_statuses.order_status_id')
            ->select(
                'orders.order_id',
                'orders.customer_id',
                'orders.order_date',
                'orders.status',
                'orders.comments',
                'orders.shipped_date',
                'orders.shipper_id',
                'order_statuses.name as status_name'
            )
            ->get();

        // Return the orders for the customer
        return response()->json($orders);
    }

    // Retrieve a specific order for a specific customer
    public function show($customer_id, $order_id)
    {
        // Get the order for the specific customer
        $order = DB::table('orders')
            ->where('customer_id', '=', $customer_id)
            ->where('order_id', '=', $order_id)
            ->join('order_statuses', 'orders.status', '=', 'order_statuses.order_status_id') // Join to get status name
            ->select(
                'orders.order_id',
                'orders.customer_id',
                'orders.order_date',
                'orders.status',
                'orders.comments',
                'orders.shipped_date',
                'orders.shipper_id',
                'order_statuses.name as status_name' // Include status name in response
            )
            ->first();

        // If no order is found, return a 404 response
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Return the order details
        return response()->json($order);
    }
}
