<form action="{{ route('guarantees.store') }}" method="POST">
    @csrf
    <input type="text" name="corporate_reference_number" placeholder="Corporate Reference Number" required>
    <select name="guarantee_type" required>
        <option value="Bank">Bank</option>
        <option value="Bid Bond">Bid Bond</option>
        <option value="Insurance">Insurance</option>
        <option value="Surety">Surety</option>
    </select>
    <input type="number" name="nominal_amount" placeholder="Nominal Amount" required>
    <input type="text" name="nominal_amount_currency" placeholder="Currency" required>
    <input type="date" name="expiry_date" required>
    <input type="text" name="applicant_name" placeholder="Applicant Name" required>
    <input type="text" name="applicant_address" placeholder="Applicant Address" required>
    <input type="text" name="beneficiary_name" placeholder="Beneficiary Name" required>
    <input type="text" name="beneficiary_address" placeholder="Beneficiary Address" required>
    <button type="submit">Submit</button>
</form>