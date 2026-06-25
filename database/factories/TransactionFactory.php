<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(100, 500000),
            'occurred_on' => fake()->date('Y-m-d'),
            'type' => fake()->randomElement(['income', 'expense',]),
            'title' => fake()->sentence(),
            'description' => fake()->optional()->text(200),
        ];
    }
}
