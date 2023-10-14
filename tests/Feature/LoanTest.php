<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_loan()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $response = $this->withSession(['banned' => false])
            ->actingAs($user)
            ->post('/loans/store', [
                'amount_required' => 1000,
                'loan_term' => 12,
            ]);

        $response->assertStatus(302); // Check for a successful redirect after creating a loan

        $this->assertDatabaseHas('loans', [
            'user_id' => $user->id,
            'amount_required' => 1000,
            'loan_term' => 12
        ]);
    }

    public function test_can_view_loan_details()
    {
        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);

        $response = $this->withSession(['banned' => false])
            ->actingAs($user)
            ->get("/loans/{$loan->id}/show/");

        $response->assertStatus(200); // Check for a successful view
        $response->assertSee($loan->amount_required);
        $response->assertSee($loan->loan_term);
    }

    public function test_can_list_own_loans($otherUser = null)
    {
        $user = User::factory()->create();
        $loans = Loan::factory(3)->create(['user_id' => $user->id]);

        $response = $this->withSession(['banned' => false])
            ->actingAs($user)
            ->get('/loans');

        $response->assertStatus(200); // Check for a successful view

        foreach ($loans as $loan) {
            $response->assertSee($user->email);
            $response->assertSee($loan->amount_required);
            $response->assertSee($loan->loan_term);
        }
    }

    public function test_cannot_list_others_loans()
    {
        $otherUser = User::factory()->create();

        $user = User::factory()->create();
        $loans = Loan::factory(3)->create(['user_id' => $user->id]);

        $response = $this->withSession(['banned' => false])
            ->actingAs($otherUser)
            ->get('/loans');

        $response->assertStatus(200); // Check for a successful view

        foreach ($loans as $loan) {
            $response->assertDontSee($user->email);
        }
    }

    public function test_admin_can_list_user_loans()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $user = User::factory()->create();
        $loans = Loan::factory(3)->create(['user_id' => $user->id]);

        $response = $this->withSession(['banned' => false])
            ->actingAs($admin)
            ->get('/loans');

        $response->assertStatus(200); // Check for a successful view

        foreach ($loans as $loan) {
            $response->assertSee($user->email);
            $response->assertSee($loan->amount_required);
            $response->assertSee($loan->loan_term);
        }
    }

    public function test_admin_can_approve_loan()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $user = User::factory()->create();
        $loan = Loan::factory()->create(['user_id' => $user->id]);

        $response = $this->withSession(['banned' => false])
            ->actingAs($admin)
            ->get("/loans/{$loan->id}/approve");

        $response->assertStatus(302); // Check for a successful redirect after creating a payment
        $this->assertDatabaseHas('loans', ['user_id' => $user->id, 'is_approved' => 1]);
        $this->assertDatabaseHas('payments', ['loan_id' => $loan->id]);
    }
}
