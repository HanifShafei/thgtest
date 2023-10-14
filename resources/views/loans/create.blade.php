@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Loan Application</h1>

        <form method="post" action="{{ route('loans.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <h1 class="h3 mb-3 fw-normal">Apply for Loans</h1>

            @include('layouts.partials.messages')

            <div class="form-group form-floating mb-3">
                <input type="number" min="1" step="1" class="form-control" name="amount_required"
                    value="{{ old('amount') }}" placeholder="Amount" required="required" autofocus>
                <label for="floatingName">Amount (RM) </label>
                @if ($errors->has('amount'))
                    <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <select class="form-control" aria-label=".form-select-sm example" name="loan_term">
                    <option value="2">2 weeks</option>
                    <option value="4">4 weeks</option>
                    <option value="8">8 weeks</option>
                    <option value="12">12 weeks</option>
                </select>

                <label for="floatingLoan_term">Tenure (weeks)</label>
                @if ($errors->has('loan_term'))
                    <span class="text-danger text-left">{{ $errors->first('loan_term') }}</span>
                @endif
            </div>

            <button class="btn btn-lg btn-primary" type="submit">Apply</button>

            @include('auth.partials.copy')
        </form>
    </div>
@endsection
