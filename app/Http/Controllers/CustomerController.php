<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all customers and exclude 'birth_date' and 'phone'
        $customers = Customer::all([
            'customer_id',
            'first_name',
            'last_name',
            'address',
            'city',
            'state',
            'points'
        ]);

        // Append is_golden_member attribute to each customer
        $customers->each(function ($customer) {
            $customer->is_golden_member = $customer->isGoldenMember();
        });

        // Return the customers with the is_golden_member indicator
        return response()->json($customers);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name',
            'last_name',
            'address',
            'city',
            'state',
            'points',
            // Add validation rules for any other fields you may have
        ]);

        // Create a new customer using the validated data
        $customer = Customer::create($validatedData);
        return $customer;



    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'customer_id' => $customer->customer_id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'address' => $customer->address,
            'city' => $customer->city,
            'state' => $customer->state,
            'points' => $customer->points,
            'is_golden_member' => $customer->isGoldenMember()
        ]);
            
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
