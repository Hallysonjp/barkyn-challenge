<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = ['gender', 'birth_date'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birth_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function createCustomer($request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = app('hash')->make($request->input('password'));
        $user->save();

        return $user->customer()->create([
            'gender' => $request->input('gender'),
            'birth_date' => $request->input('birth_date')
        ]);
    }

    public function updateCustomer($input, $customer)
    {
        $customer->update([
            'gender'     => $input['gender'],
            'birth_date' => $input['birth_date']
        ]);
        $customer->user()->update([
            'name'  => $input['name'],
            'email' => $input['email']
        ]);

        return $customer;
    }
}
