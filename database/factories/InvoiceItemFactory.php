<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    public function definition()
    {
        return [
            'invoice_id' => Invoice::factory(),
            'item_id' => Item::inRandomOrder()->value('id') ?? 1,
            'description' => fake()->sentence(),
            'qty' => fake()->numberBetween(1, 10),
            'price' => fake()->randomFloat(2, 100000, 5000000),
            'amount' => fake()->randomFloat(2, 100000, 5000000),
        ];
    }
}
