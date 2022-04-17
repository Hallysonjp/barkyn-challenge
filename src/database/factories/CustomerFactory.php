<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = ['male', 'female', 'other'];
        $users = User::all();

        return [
            'user_id' => $this->faker->unique()->numberBetween(1, $users->count()),
            'gender' => $gender[rand(0, 2)],
            'birth_date' => $this->faker->dateTimeThisCentury(),
        ];
    }
}
