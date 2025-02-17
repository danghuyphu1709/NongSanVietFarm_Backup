<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.categories.';
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(CategoryCreateRequest $request)
    {
        $request['slug'] = Str::slug($request['name']);
        $this->categoryRepository->create($request->all());

        return redirect()
            ->route('categories.index')
            ->with('created', 'Thêm mới danh mục thành công');
    }

    public function show(Category $category)
    {
        $this->categoryRepository->findOrFail($category->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    public function edit(Category $category)
    {
        $this->categoryRepository->findOrFail($category->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $request['slug'] = Str::slug($request['name']);
        $this->categoryRepository->update($category->id, $request->all());

        return back()
            ->with('updated', 'Cập nhật danh mục thành công');
    }

    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category->id);

        return response()->json(true);

    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->destroy($category->id);

        return response()->json(true);
    }
}
