<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model{
    protected $table = "pets";

    protected $fillable = ['name', 'gender', 'lifestage', 'weight'];

    // public $timestamps = false;

    public function subscription()
    {
        return $this->belongsTo(SubscriptionPets::class);
    }
}
