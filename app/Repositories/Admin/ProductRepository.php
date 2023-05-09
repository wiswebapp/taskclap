<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Product;

class ProductRepository implements MasterInterface
{
    public function getAll()
    {
        return Product::whereNull('parent_id');
    }

    public function getRaw($filterData = "")
    {
        $query = Product::whereNull('parent_id');
        if ($filterData['category']) {
            $query = $query->where('category_id', $filterData['category']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function delete($id)
    {
        Product::destroy($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Product::whereId($id)->update($newDetails);
    }
}
