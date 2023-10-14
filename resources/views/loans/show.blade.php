@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-3 rounded">
        <h1>Loan Details</h1>

        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead fw-bold mb-1">Debtor</p>
                    <p class="text-muted mb-0">Name : {{ $loan->user->username }}</p>
                    <p class="text-muted mb-0">Email : {{ $loan->user->email }}</p>
                </div>
                <div class="col">
                    <p class="lead fw-bold mb-1">Loan</p>
                    <p class="text-muted mb-0">Amount : RM {{ $loan->amount_required }}.00</p>
                    <p class="text-muted mb-0">Tenure : {{ $loan->loan_term }} weeks</p>
                </div>
            </div>
        </div>

        <h2>Payment Schedule</h2>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>Week</th>
                        <th class="text-end">Payments</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loan->payments as $payment)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{ $payment->week }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-end">
                                    <p class="fw-normal mb-0">RM {{ $payment->amount }}.00</p>
                                </div>
                            </td>
                            <td>
                                @can('isAdmin')
                                    @if ($payment->is_paid)
                                        <p class="text-success"><strong>PAID</strong></p>
                                    @else
                                        <p class="text-danger"><strong>unpaid</strong></p>
                                    @endif
                                @else
                                    @if (!$payment->is_paid)
                                        <a class="btn btn-sm btn-danger" onclick="return confirm('Pay this loan?')"
                                            href="{{ route('loans.payments.pay', [$loan->id, $payment->id]) }}">Make payment</a>
                                    @else
                                        <p class="text-success"><strong>PAID</strong></p>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                Loan awating approval.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
