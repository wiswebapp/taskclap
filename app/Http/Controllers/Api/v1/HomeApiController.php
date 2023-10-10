<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;

class HomeApiController extends BaseApiController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

    public function getHomeData()
    {
        $authUser = auth('sanctum')->user();
        $fieldToGet =  ['id', 'slug', 'name', 'description', 'image'];
        $urlPrefix = asset('storage' . DIRECTORY_SEPARATOR  . Category::UPLOAD_PATH . DIRECTORY_SEPARATOR );

        $categories = $this->categoryRepository->getRaw(['status' => 'Active','parent_id' => null])->select($fieldToGet)->get();
        $categories = $categories->map(function ($row) use($urlPrefix) {
            $row->image = $urlPrefix . $row->image;
            $row->children->map(function ($child, $key) use($row, $urlPrefix) {
                $counter = $key + $counter;
                $row->children[$counter]->image = $urlPrefix . $child->image;
            });
            return $row;
        })->reject(function ($category) {
            return $category->children->count() == 0;
        });
        $returnArr['category'] = array_values($categories->toArray());
        if ($authUser) {
            $returnArr['user'] = $authUser;
        }

        return $this->sendSuccessResponse('Data listed successfully!', $returnArr);
    }
}
