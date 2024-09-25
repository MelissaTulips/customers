<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ensure you import DB facade

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//Laravel query bulder
        $results = DB::table('customers as c')
            ->join('orders as o', 'c.customer_id', '=', 'o.customer_id')
            ->join('order_statuses as os', 'o.status', '=', 'os.order_status_id')
            ->select(
                'c.customer_id',
                'c.first_name',
                'c.last_name',
                'c.address',
                'c.city',
                'c.state',
                'c.points',
                'o.order_date',
                'os.name as order_status_name'
            )
            ->get();

            return $results;
         }

         
         


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'points' => 'required|integer|min:0'
        ]);
    
        // Create a new customer
        $customer = Customer::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'points' => $validatedData['points'],
        ]);
    
        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Customer created successfully!',
            'customer' => $customer
        ], 201);
    }
    

    public function show($customer_id)
    {
        // Get the customer with the specified customer_id
        $customer = DB::table('customers')
            ->where('customer_id', '=', $customer_id)
            ->first();
    
        // If no customer is found, return a 404 response
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    
        // Get the customer's orders
        $orders = DB::table('orders')
            ->where('customer_id', '=', $customer_id)
            ->get();
    
        // Add orders to the customer data
        $customer->orders = $orders;
    
        return response()->json($customer);
    }



public function getOrders($customer_id)
{
    // Get all orders for a specific customer
    $orders = DB::table('orders')
        ->where('customer_id', '=', $customer_id)
        ->join('order_statuses', 'orders.status', '=', 'order_statuses.order_status_id') // Join to get status name
        ->select(
            'orders.order_id',
            'orders.customer_id',
            'orders.order_date',
            'orders.status',
            'orders.comments',
            'orders.shipped_date',
            'orders.shipper_id',
            'order_statuses.name as status_name' // Select status name
        )
        ->get();

    // If no orders are found, return an empty array
    return response()->json($orders);
}

    
    





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
