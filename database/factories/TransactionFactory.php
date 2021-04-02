<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'payer_id' => User::all()->random()->id,
            'payee_id' => User::all()->random()->id,
            'value' => $faker->randomFloat(2, 1, 1000),
        ];
    }
}
