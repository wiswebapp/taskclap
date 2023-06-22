<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

    public function homepage(): View
    {
        $categories = $this->categoryRepository->getParentCategory()->where('status', 'Active');
        $categories = $categories->reject(function ($category) {
            return $category->children->count() == 0;
        });

        return view('homepage', [
            'categories' => $categories,
        ]);
    }

    public function category($categorySlug): View
    {
        $catData = $this->categoryRepository->getById($categorySlug, true);
        return view('category', [
            'category' => $catData,
        ]);
    }

    public function categoryDetail(): View
    {
        return view('category_detail', [
            //
        ]);
    }
}
