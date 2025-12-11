<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkOrderFactory extends Factory
{
    public function definition()
    {
        return [
            'number' => 'WO-' . fake()->unique()->numerify('#####'),
            'client_id' => Client::factory(),
            'product_id' => Product::factory(),
            'issue_date' => fake()->date(),
            'start_date' => fake()->date(),
            'finish_date' => fake()->date(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
