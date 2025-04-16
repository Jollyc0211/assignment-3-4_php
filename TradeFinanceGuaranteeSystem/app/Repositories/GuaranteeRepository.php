<?php
namespace App\Repositories;

use App\Models\Guarantee;

class GuaranteeRepository
{
    public function getAll()
    {
        return Guarantee::all();
    }

    public function create(array $data)
    {
        return Guarantee::create($data);
    }

    public function find($id)
    {
        return Guarantee::findOrFail($id);
    }

    public function update($id, array $data)
    {
        return Guarantee::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Guarantee::destroy($id);
    }
}
