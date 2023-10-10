<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function __construct(private CategoryRepository $categoryRepository, private FilesService $fileService) {
        $this->categoryRepository = $categoryRepository;
        $this->fileService = $fileService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->categoryRepository->getRaw($request?->filterData);
            if (empty($request->order)) {
                $data->latest('id');
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($row) {
                        return '<span class="badge badge-'. ($row->status == "Active" ? "success" : "danger") .'">'. $row->status .'</span>' .
                        PHP_EOL;
                    })
                    ->addColumn('parent', function($row) {
                        return ($row?->parent->name ? $row->parent->name : 'N/A');
                    })
                    ->addColumn('action', function($row) {
                            return '<div style="width: 150px">' .
                            '<a href="'. route('admin.categorys.edit', $row->id) .'" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                            '<button onclick="removeData('. $row->id. ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                            '<div>' .
                            PHP_EOL;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.category.index', [
            'categoryData' => $this->categoryRepository->getParentCategory()
        ]);
    }

    public function create(): View
    {
        return view('admin.category.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.categorys.store'),
            'categoryData' => $this->categoryRepository->getParentCategory(),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $validated['image'] = $this->fileService->generateFileName('cat', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Category::UPLOAD_PATH,
                $validated['image']
            );
        }
        $validated['slug'] = Str::slug($validated['name']);
        $this->categoryRepository->create($validated);

        return redirect(route('admin.categorys.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Category $category): View
    {
        return view('admin.category.alter', [
            'category' => $category,
            'action' => 'Edit',
            'actionUrl' => route('admin.categorys.update', $category),
            'categoryData' => $this->categoryRepository->getParentCategory($category->id),
        ]);
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $this->fileService->removeFile(Category::UPLOAD_PATH, $category->image);
            $validated['image'] = $this->fileService->generateFileName('cat', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Category::UPLOAD_PATH,
                $validated['image']
            );
        }
        $validated['slug'] = Str::slug($validated['name']);
        $this->categoryRepository->update($category->id, $validated);
        return redirect(route('admin.categorys.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Category $category): void
    {
        if ($category->image) {
            $this->fileService->removeFile(Category::UPLOAD_PATH, $category->image);
        }

        $this->categoryRepository->delete($category->id);
        echo json_encode(['success' => true]);
    }

    public function fetchCategory(Request $request)
    {
        $data = $this->categoryRepository->getRaw(['status' => 'Active'])->where('parent_id', null)->select('id', 'name');
        if ($cat = $request->id) {
            $data->where('id', $cat);
        }
        echo json_encode(['success' => true,'data' => $data->get()]);
    }

    public function fetchSubcategory(Request $request)
    {
        $data = $this->categoryRepository->getRaw(['status' => 'Active'])->select('id', 'name');
        if ($cat = $request->category) {
            $data->where('parent_id', $cat);
        }
        echo json_encode(['success' => true,'data' => $data->get()]);
    }
}
