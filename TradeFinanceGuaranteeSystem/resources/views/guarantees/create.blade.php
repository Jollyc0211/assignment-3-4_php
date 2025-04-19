@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Guarantee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('guarantees.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Corporate Reference Number</label>
            <input type="text" name="corporate_reference_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Guarantee Type</label>
            <select name="guarantee_type" class="form-control" required>
                <option value="Bank">Bank</option>
                <option value="Bid Bond">Bid Bond</option>
                <option value="Insurance">Insurance</option>
                <option value="Surety">Surety</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Nominal Amount</label>
            <input type="number" step="0.01" name="nominal_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nominal Amount Currency</label>
            <input type="text" name="nominal_amount_currency" maxlength="3" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Applicant Name</label>
            <input type="text" name="applicant_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Applicant Address</label>
            <textarea name="applicant_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Beneficiary Name</label>
            <input type="text" name="beneficiary_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Beneficiary Address</label>
            <textarea name="beneficiary_address" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Guarantee</button>
    </form>
</div>
@endsection
