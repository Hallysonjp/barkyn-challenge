<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubscriptionPets extends Model{
    protected $table = "subscription_pets";

    protected $fillable = ['subscription_id', 'pet_id'];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'id', 'pet_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }

    public function getPetsBySubscription($subscription_id)
    {
        return DB::table($this->table)->select(
            "subscriptions.id",
            "subscriptions.customer_id",
            "subscriptions.base_price",
            "subscriptions.total_price",
            "subscriptions.next_order_date",
            "pets.name",
            "pets.gender",
            "pets.lifestage",
            "pets.weight"
        )
            ->join("pets", "subscription_pets.pet_id",'=', 'pets.id')
            ->join("subscriptions", "subscription_pets.subscription_id", "=", "subscriptions.id")
            ->where("subscriptions.id", "=", $subscription_id)
            ->get();
    }
}
