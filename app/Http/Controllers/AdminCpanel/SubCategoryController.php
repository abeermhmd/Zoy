<?php

namespace App\Http\Controllers\AdminCpanel;

use App\DataTransferObjects\SubCategories\SubCategoryDataTransfer;
use App\Models\Category;
use App\Contracts\{CategoryContract, SubCategoryContract};
use App\DataTransferObjects\Categories\CategoryFilterDataTransfer;
use App\DataTransferObjects\SubCategories\SubCategoryFilterDataTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class SubCategoryController extends Controller
{
    public function __construct(protected SubCategoryContract $subCategoryContract,
                                protected CategoryContract    $categoryContract)
    {
        $this->middleware(function ($request, $next) {
            if (!can('categories')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index()
    {
        $dtoFilterData = SubCategoryFilterDataTransfer::fromRequest(request());
        $items = $this->subCategoryContract->getSubCategories($dtoFilterData);
        $mainCategoriesFilter = new CategoryFilterDataTransfer(isPaginate: false, status: 'active');
        $categories = $this->categoryContract->getCategories($mainCategoriesFilter);
        return view('adminCpanel.subCategories.home', compact('items', 'categories'));
    }

    public function create()
    {
        $mainCategoriesFilter = new CategoryFilterDataTransfer(isPaginate: false, status: 'active');
        $mainCategories = $this->categoryContract->getCategories($mainCategoriesFilter);
        $item = new Category();
        return view('adminCpanel.subCategories.create', compact('item', 'mainCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $dtoSubCat = SubCategoryDataTransfer::fromRequest($request);
        $this->subCategoryContract->createSubCategory($dtoSubCat);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = $this->subCategoryContract->getSubCategory($id);
        $mainCategoriesFilter = new CategoryFilterDataTransfer(isPaginate: false, status: 'active');
        $mainCategories = $this->categoryContract->getCategories($mainCategoriesFilter);
        return view('adminCpanel.subCategories.edit', compact('item', 'mainCategories'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $dtoSubCat = SubCategoryDataTransfer::fromRequest($request);
        $item = $this->subCategoryContract->getSubCategory($id);
        $this->subCategoryContract->updateSubCategory($item, $dtoSubCat);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
