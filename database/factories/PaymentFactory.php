<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition()
    {
        return [
            'number' => 'PAY-' . fake()->unique()->numerify('#####'),
            'date' => fake()->date(),
            'client_id' => Client::factory(),
            'invoice_id' => Invoice::factory(),
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 500000, 10000000),
            'is_posted' => fake()->boolean(),
        ];
    }
}
