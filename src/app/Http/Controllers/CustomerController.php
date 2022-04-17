<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use Tymon\JWTAuth\Claims\Custom;

class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $customers = Customer::with('user')->get();
        return $this->sendResponse(
            CustomerResource::collection($customers),
            'Customers retrieved succesfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        $customer = (new Customer())->createCustomer($request);
        return $this->sendResponse(new CustomerResource($customer), 'Customer saved succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomerRequest $request, $id)
    {
        $input    = $request->validated();
        $customer = Customer::find($id);
        $result   = (new Customer())->updateCustomer($input, $customer);

        return $this->sendResponse(new CustomerResource($result), 'Customer updated succesfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCustomerName(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->user()->update(['name' => $request->input('name')]);

        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->user()->delete();
        $customer->delete();

        return $this->sendResponse([], 'Customer deleted succesfully.');
    }
}
