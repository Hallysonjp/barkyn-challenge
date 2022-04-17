<?php

namespace App\Models;

use App\Http\Requests\PetRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pet extends Model
{
    protected $table = "pets";

    protected $fillable = ['name', 'gender', 'lifestage', 'weight'];

    // public $timestamps = false;

    public function subscription()
    {
        return $this->belongsTo(SubscriptionPets::class);
    }

    public function createPet(PetRequest $request)
    {
        $subscription = DB::table('subscriptions')
            ->select('subscriptions.*', 'customers.user_id')
            ->join('customers', 'customers.id', '=', 'subscriptions.customer_id')
            ->where('customers.user_id', Auth::id())
            ->first();

        if (!empty($subscription)) {
            $pet = Pet::create($request->all());
            $subscriptionPets = SubscriptionPets::create(['pet_id' => $pet->id, 'subscription_id' => $subscription->id]);
            if (!empty($subscriptionPets)) {
                return $pet;
            }
        }
        return null;
    }
}
