@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-3 rounded">
        <h1 class="text-center">
            @can('isAdmin')
                Loans lists
            @else
                My Loans
            @endcan
        </h1>

        @can('isUser')
            <div class="text-end mb-3">
                <a class="btn btn-md btn-primary" href="{{ route('loans.create') }}" role="button">Apply for loans &raquo;</a>
            </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>Debtor</th>
                        <th class="text-end">Loans</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td style='cursor: pointer; cursor: hand;'
                                onclick="window.location='{{ route('loans.show', $loan->id) }}';">
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{ $loan->user->username }}</p>
                                        <p class="text-muted mb-0">{{ $loan->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-end">
                                    <p class="fw-normal mb-0">RM {{ $loan->amount_required }}.00</p>
                                    <p class="fw-normal mb-1">Tenure: {{ $loan->loan_term }} weeks</p>
                                </div>
                            </td>
                            <td>
                                @can('isAdmin')
                                    @if (!$loan->is_approved)
                                        <a class="btn btn-sm btn-danger" onclick="return confirm('Approve this loan?')"
                                            href="{{ route('loans.approve', $loan->id) }}">Approve</a>
                                    @else
                                        <p class="text-success"><strong>Approved</strong></p>
                                    @endif
                                @else
                                    @if ($loan->is_approved)
                                        <p class="text-success"><strong>Approved</strong></p>
                                    @else
                                        Awaiting approval
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                No loans applied.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
