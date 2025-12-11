<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => 'PRD' . str_pad(fake()->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'name' => fake()->words(3, true), // ganti productName()
            'specification' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'author_code' => fake()->numerify('AC###'),
            'author_name' => fake()->name(),
            'compiler' => fake()->name(),
            'year' => fake()->year(),
            'product_group_id' => 1, // sementara fixed / bisa random kalau group sudah ada
            'is_active' => true,
        ];
    }
}
