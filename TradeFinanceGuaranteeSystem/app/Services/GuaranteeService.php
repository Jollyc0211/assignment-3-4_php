<?php

namespace App\Services;

use App\Repositories\Contracts\GuaranteeRepositoryInterface;

class GuaranteeService
{
    protected $guaranteeRepository;

    public function __construct(GuaranteeRepositoryInterface $guaranteeRepository)
    {
        $this->guaranteeRepository = $guaranteeRepository;
    }

    public function listGuarantees()
    {
        return $this->guaranteeRepository->getAll();
    }

    public function getGuarantee($id)
    {
        return $this->guaranteeRepository->findById($id);
    }

    public function createGuarantee(array $data)
    {
        return $this->guaranteeRepository->create($data);
    }

    public function updateGuarantee($id, array $data)
    {
        return $this->guaranteeRepository->update($id, $data);
    }

    public function deleteGuarantee($id)
    {
        return $this->guaranteeRepository->delete($id);
    }

    public function updateStatus($id, $status)
    {
        $guarantee = $this->guaranteeRepository->findById($id);
        if ($guarantee) {
            $guarantee->status = $status;
            $guarantee->save();
        }
        return $guarantee;
    }
}
