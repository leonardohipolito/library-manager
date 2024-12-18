<?php

namespace Database\Factories;

use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'returned_at' => null,
            'status' => LoanStatus::options()->keys()->random(),
            'book_id' => \App\Models\Book::factory(),
            'borrower_id' => \App\Models\User::factory(),
            'attendant_id' => \App\Models\User::factory(),
        ];
    }
}
