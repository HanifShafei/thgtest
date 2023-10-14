<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use App\Models\Payment;
use App\Events\LoanApproved;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_make_payment()
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);

        event(new LoanApproved($loan));

        $payment = Payment::where('loan_id', $loan->id)->first();

        $response = $this->withSession(['banned' => false])
            ->actingAs($user)
            ->get("/loans/{$loan->id}/payments/{$payment->id}/pay");

        $response->assertStatus(302); // Check for a successful redirect after creating a payment
        $this->assertDatabaseHas('payments', ['is_paid' => 1, 'loan_id' => $loan->id]);
    }
}
