<?php

namespace App\Repositories;

use App\Models\Guarantee;
use App\Repositories\Contracts\GuaranteeRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class GuaranteeRepository implements GuaranteeRepositoryInterface
{
    public function getAll()
    {
        return Guarantee::all();
    }

    public function findById($id)
    {
        return Guarantee::findOrFail($id);
    }

    public function create(array $data)
    {
        return Guarantee::create($data);
    }

    public function update($id, array $data)
    {
        $guarantee = Guarantee::findOrFail($id);
        $guarantee->update($data);
        return $guarantee;
    }

    public function delete($id)
    {
        $guarantee = Guarantee::findOrFail($id);
        return $guarantee->delete();
    }

    /**
     * Create or Update Guarantees in Bulk.
     *
     * @param array $data
     * @return void
     */
    public function createOrUpdateBulk(array $data)
    {
        DB::beginTransaction(); // Start transaction

        try {
            foreach ($data as $item) {
                // Validate each record before inserting or updating
                $this->validateData($item);

                // Create or update guarantee based on Corporate Reference Number
                Guarantee::updateOrCreate(
                    ['corporate_reference_number' => $item['corporate_reference_number']],
                    $item
                );
            }

            DB::commit(); // Commit the transaction
        } catch (Exception $e) {
            DB::rollBack(); // Rollback in case of failure
            throw $e;
        }
    }

    /**
     * Validate Guarantee data before saving.
     *
     * @param array $data
     * @throws \Exception
     */
    private function validateData(array $data)
    {
        // Validate Expiry Date (must be a future date)
        if (strtotime($data['expiry_date']) <= time()) {
            throw new Exception("Expiry Date for Corporate Reference Number {$data['corporate_reference_number']} must be a future date.");
        }

        // Validate Corporate Reference Number (must be unique)
        $validator = Validator::make($data, [
            'corporate_reference_number' => 'required|unique:guarantees,corporate_reference_number',
            'guarantee_type' => 'required|string',
            'nominal_amount' => 'required|numeric',
            'nominal_amount_currency' => 'required|string',
            'expiry_date' => 'required|date',
            'applicant_name' => 'required|string',
            'applicant_address' => 'required|string',
            'beneficiary_name' => 'required|string',
            'beneficiary_address' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new Exception('Validation failed for the guarantee: ' . implode(', ', $validator->errors()->all()));
        }
    }
}
