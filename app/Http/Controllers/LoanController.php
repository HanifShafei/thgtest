<?php

namespace App\Http\Controllers;

use App\Events\LoanApproved;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user');

        if (Gate::denies('isAdmin')) {
            $loans = $loans->where('user_id', Auth::user()->id);
        }

        $loans = $loans->get();

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount_required' => 'required|numeric',
            'loan_term' => 'required|integer',
        ]);

        $data['user_id'] = Auth::user()->id;

        Loan::create($data);

        return redirect()->route('loans.index');
    }

    public function approve(Loan $loan) {
        $this->authorize('isAdmin');

        $loan->is_approved = 1;
        $loan->save();

        event(new LoanApproved($loan));

        return redirect()->route('loans.index');
    }

    public function show(Loan $loan)
    {
        $loans = Loan::with('user', 'payments')->find($loan->id);

        return view('loans.show', compact('loan'));
    }
}
