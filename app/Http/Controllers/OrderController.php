<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Customer $customer)
    {

        return $customer->orders;

        // Raw SQL query to retrieve order info along with status name
        $orders = DB::select("
            SELECT 
                o.order_id,
                o.customer_id,
                o.order_date,
                o.status,
                o.comments,
                o.shipped_date,
                o.shipper_id,
                os.name AS status_name
            FROM 
                orders o
            JOIN 
                order_statuses os ON o.status = os.order_status_id
        ");
    
        // Return the orders and their statuses as a JSON response
        return response()->json($orders);
    }


    public function show($customer_id, $order_id)
{
    // Get the order for the specific customer
    $order = DB::table('orders')
        ->where('customer_id', '=', $customer_id)
        ->where('order_id', '=', $order_id)
        ->first();

    // If no order is found, return a 404 response
    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Return the order details
    return response()->json($order);
}

    
}
