<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Category;

class CategoryRepository implements MasterInterface
{
    public function getAll()
    {
        return Category::all();
    }

    /**
     * Returns the parent category data
     *
     * @param int $except [Single Id to be ignored]
     */
    public function getParentCategory($igore = '')
    {
        $data = Category::whereNull('parent_id');
        if ($igore) {
            $data->where('id', '!=', $igore);
        }

        return $data->get();
    }

    /**
     * Returns the Child category data
     *
     * @param int $parentId [Category_id]
     */
    public function getChildCategory($parentId = '')
    {
        $data = Category::whereNotNull('parent_id');
        if ($parentId) {
            $data->where('parent_id', $parentId);
        }

        return $data->get();
    }

    public function getRaw($filterData = "")
    {
        $query = Category::query();
        if ($filterData && $filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }
        if ($filterData && $filterData['category']) {
            $query = $query->where('parent_id', $filterData['category']);
        }

        return $query;
    }

    public function getById($id, $findBySlug = false)
    {
        if ($findBySlug) {
            return Category::where('slug', $id)->first();
        }

        return Category::findOrFail($id);
    }

    public function delete($id)
    {
        Category::destroy($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Category::whereId($id)->update($newDetails);
    }
}
