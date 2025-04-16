<?php
namespace App\Services;

use App\Repositories\GuaranteeRepository;

class GuaranteeService
{
    protected $repository;

    public function __construct(GuaranteeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createGuarantee(array $data)
    {
        return $this->repository->create($data);
    }

    public function getGuarantee($id)
    {
        return $this->repository->find($id);
    }

    public function updateGuarantee($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteGuarantee($id)
    {
        return $this->repository->delete($id);
    }
}