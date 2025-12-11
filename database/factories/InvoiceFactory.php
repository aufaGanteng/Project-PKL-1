<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\InvoiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition()
    {
        return [
            'number' => 'INV-' . fake()->unique()->numerify('#####'),
            'date' => fake()->date(),
            'due_date' => fake()->date(),
            'client_id' => Client::factory(),
            'invoice_type_id' => InvoiceType::inRandomOrder()->value('id') ?? 1,
            'description' => fake()->sentence(),
            'dpp' => fake()->randomFloat(2, 100000, 10000000),
            'ppn' => fake()->randomFloat(2, 100000, 10000000),
            'is_posted' => fake()->boolean(),
            'is_active' => true,
        ];
    }
}
