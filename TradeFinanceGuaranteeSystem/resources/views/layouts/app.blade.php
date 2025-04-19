<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GuaranteeService;

class GuaranteeController extends Controller
{
    protected $guaranteeService;

    public function __construct(GuaranteeService $guaranteeService)
    {
        $this->guaranteeService = $guaranteeService;
    }

    public function index()
    {
        $guarantees = $this->guaranteeService->listGuarantees();
        return view('guarantees.index', compact('guarantees'));
    }

    public function create()
    {
        return view('guarantees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'corporate_reference_number' => 'required|unique:guarantees',
            'guarantee_type' => 'required|in:Bank,Bid Bond,Insurance,Surety',
            'nominal_amount' => 'required|numeric',
            'nominal_amount_currency' => 'required|string|max:3',
            'expiry_date' => 'required|date|after:today',
            'applicant_name' => 'required|string',
            'applicant_address' => 'required|string',
            'beneficiary_name' => 'required|string',
            'beneficiary_address' => 'required|string',
        ]);

        $this->guaranteeService->createGuarantee($request->all());

        return redirect()->route('guarantees.index')->with('success', 'Guarantee created successfully.');
    }

    public function show($id)
    {
        $guarantee = $this->guaranteeService->getGuarantee($id);
        return view('guarantees.show', compact('guarantee'));
    }

    public function edit($id)
    {
        $guarantee = $this->guaranteeService->getGuarantee($id);
        return view('guarantees.edit', compact('guarantee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guarantee_type' => 'required|in:Bank,Bid Bond,Insurance,Surety',
            'nominal_amount' => 'required|numeric',
            'nominal_amount_currency' => 'required|string|max:3',
            'expiry_date' => 'required|date|after:today',
            'applicant_name' => 'required|string',
            'applicant_address' => 'required|string',
            'beneficiary_name' => 'required|string',
            'beneficiary_address' => 'required|string',
        ]);

        $this->guaranteeService->updateGuarantee($id, $request->except('corporate_reference_number'));

        return redirect()->route('guarantees.index')->with('success', 'Guarantee updated successfully.');
    }

    public function destroy($id)
    {
        $this->guaranteeService->deleteGuarantee($id);
        return redirect()->route('guarantees.index')->with('success', 'Guarantee deleted successfully.');
    }

    public function review($id)
    {
        $this->guaranteeService->updateStatus($id, 'review');
        return back()->with('success', 'Guarantee submitted for review.');
    }

    public function apply($id)
    {
        $this->guaranteeService->updateStatus($id, 'applied');
        return back()->with('success', 'Guarantee applied.');
    }

    public function issue($id)
    {
        $this->guaranteeService->updateStatus($id, 'issued');
        return back()->with('success', 'Guarantee issued.');
    }

}
