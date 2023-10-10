<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Admin\CategoryRepository;

class CategoryApiController extends BaseApiController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }



    public function getSubCategory($category)
    {
        $urlPrefix = asset('storage' . DIRECTORY_SEPARATOR  . Category::UPLOAD_PATH . DIRECTORY_SEPARATOR );
        $category = $this->categoryRepository->getById($category, true);
        if (empty($category) || empty($category)) {
            return $this->sendFailedResponse('Invalid category selected', self::HTTP_UNPROCESSABLE);
        }

        $subCategories = $this->categoryRepository->getChildCategory($category->id);
        $subCategories->map(function($subcat) use($urlPrefix) {
            $subcat->image = $urlPrefix . $subcat->image;
            return $subcat;
        });

        return $this->sendSuccessResponse('Data listed successfully!', $subCategories);
    }
}
