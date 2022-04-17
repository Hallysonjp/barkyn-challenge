<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Subscription extends Model{
    protected $table = "subscriptions";

    protected $fillable = ['customer_id', 'base_price', 'total_price', 'next_order_date'];

    protected $dates = ['next_order_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pets()
    {
        return $this->hasMany(SubscriptionPets::class);
    }
}
