<?php

namespace Database\Factories;

use App\Models\User;
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
            // 'name' => fake()->name(),
            // 'username' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),

            'user_id' => fake()->randomElement(User::all())['id'],
            'amount_required' => fake()->numerify('#####'),
            'loan_term' => fake()->randomElement([2, 4, 8, 12]),
            'is_approved' => fake()->randomElement([0, 1]),




            // $table->id();
            // $table->string('user_id');
            // $table->string('amount_required');
            // $table->string('loan_term');
            // $table->string('is_approved')->default(0);
            // $table->timestamps();

        ];
    }
}
