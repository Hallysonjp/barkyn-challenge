<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Customer;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Resources\Subscription as SubscriptionResource;
use App\Models\Subscription;
use App\Models\SubscriptionPets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subscriptions = Subscription::with('customer')->get();

        return $this->sendResponse(
            SubscriptionResource::collection($subscriptions),
            'Subscriptions retrieved succesfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubscriptionRequest $request)
    {
        $result = (new Subscription())->createSubscription($request);
        return $this->sendResponse(new SubscriptionResource($result), 'Subscription saved succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);

        if (is_null($subscription)) {
            return $this->sendError('Subscription not found.');
        }

        return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubscriptionRequest $request, $id)
    {
        $input = $request->validated();
        $subscription = Subscription::find($id);
        $subscription->update($input);

        return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNextOrderdate(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        $subscription->update(['next_order_date' => $request->input('next_order_date')]);

        return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Subscription::find($id);
        $customer->delete();

        return $this->sendResponse([], 'Subscription deleted succesfully.');
    }

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscriptionsByCustomer($id)
    {
        $subscription = Subscription::with('customer')
            ->where('customer_id', '=', $id)
            ->orderByDesc('id')
            ->first();

        if (is_null($subscription))
            return $this->sendError('Subscription not found');

        return $this->sendResponse(
            new SubscriptionResource($subscription),
            'Subscriptions retrieved succesfully'
        );
    }

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  int  $subscription_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPetsBySubscription($subscription_id)
    {
        $result = (new SubscriptionPets())->getPetsBySubscription($subscription_id);
        return $this->sendResponse($result, "Pets retrieved successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPet($pet_id)
    {
        $subscriptionPet = SubscriptionPets::with('pets')->where('pet_id', '=', $pet_id)->first();
        $subscriptionPet->pets()->delete();
        $subscriptionPet->delete();

        return $this->sendResponse([], 'Subscription deleted succesfully.');
    }
}
