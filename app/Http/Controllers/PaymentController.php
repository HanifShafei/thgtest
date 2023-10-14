<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Events\LoanApproved;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Loan $loan)
    {
        return view('payments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $loan->payments()->create($data);

        return redirect()->route('loans.show', $loan);
    }

    public function pay(Loan $loan, Payment $payment) {
        $payment->is_paid = 1;
        $payment->save();

        return redirect()->back();
    }

}
