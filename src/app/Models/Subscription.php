<?php

namespace App\Models;

use App\Http\Requests\SubscriptionRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Subscription extends Model
{
    use HasFactory;

    protected $table    = "subscriptions";
    protected $fillable = ['customer_id', 'base_price', 'total_price', 'next_order_date', 'is_active', 'start_at', 'end_at'];
    protected $dates    = ['next_order_date', 'start_at', 'end_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pets()
    {
        return $this->hasMany(SubscriptionPets::class);
    }

    public function createSubscription(SubscriptionRequest $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $subscription = Subscription::where(['customer_id' => $customer->id, 'is_active' => 1])->first();
        $request->request->add(['is_active' => 1]);
        $request->request->add(['customer_id' => $customer->id]);
        $request->request->add(['start_at' => Carbon::now()]);
        $request->request->add(['end_at' => Carbon::now()->addMonth()]);

        if (empty($subscription)) {
            $subscription = Subscription::create($request->all());
        } else {
            $subscription->update($request->all());
        }
        return $subscription;
    }
}
