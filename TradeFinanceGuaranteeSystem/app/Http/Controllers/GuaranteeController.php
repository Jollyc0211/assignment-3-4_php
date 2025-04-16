<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GuaranteeService;

class GuaranteeController extends Controller
{
    protected $service;

    public function __construct(GuaranteeService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'corporate_reference_number' => 'required|unique:guarantees',
            'guarantee_type' => 'required',
            'nominal_amount' => 'required|numeric|min:1',
            'nominal_amount_currency' => 'required|string',
            'expiry_date' => 'required|date|after:today',
            'applicant_name' => 'required|string|max:255',
            'applicant_address' => 'required|string|max:255',
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_address' => 'required|string|max:255',
        ]);

        $this->service->createGuarantee($validated);
        return redirect()->route('dashboard')->with('success', 'Guarantee created successfully');
    }

    public function review($id)
    {
        $guarantee = $this->service->getGuarantee($id);
        return view('guarantees.review', compact('guarantee'));
    }

    public function apply($id)
    {
        $guarantee = $this->service->updateGuarantee($id, ['status' => 'Applied']);
        return redirect()->route('dashboard')->with('success', 'Guarantee applied successfully');
    }

    public function issue($id)
    {
        $guarantee = $this->service->updateGuarantee($id, ['status' => 'Issued']);
        return redirect()->route('dashboard')->with('success', 'Guarantee issued successfully');
    }

    public function destroy($id)
    {
        $this->service->deleteGuarantee($id);
        return redirect()->route('dashboard')->with('success', 'Guarantee deleted successfully');
    }
}