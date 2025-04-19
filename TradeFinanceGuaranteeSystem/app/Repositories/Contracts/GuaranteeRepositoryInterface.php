<?php

namespace App\Repositories\Contracts;

use App\Models\Guarantee;

interface GuaranteeRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
