<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Contracts\CategoryContract;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use App\DataTransferObjects\Categories\CategoryFilterDataTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\{Category, Setting};
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryContract $categoryContract)
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
        $dtoFilter = CategoryFilterDataTransfer::fromRequest(request());
        $items = $this->categoryContract->getCategories($dtoFilter);
        return view('adminCpanel.categories.home', compact('items'));
    }

    public function create()
    {
        $item = new Category();
        return view('adminCpanel.categories.create', compact('item'));
    }

    public function store(CategoryRequest $request)
    {
        $dtoData = CategoryDataTransfer::fromRequest($request);
        $this->categoryContract->createCategory($dtoData);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = $this->categoryContract->getCategory($id);
        return view('adminCpanel.categories.edit', compact('item'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $dtoData = CategoryDataTransfer::fromRequest($request);
        $item = $this->categoryContract->getCategory($id);
        $this->categoryContract->updateCategory($item, $dtoData);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function toggleFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if ($category->subcategories()->exists()) {
            $category->is_featured = $category->is_featured === 'yes' ? 'no' : 'no';
            $category->save();
            return response()->json([
                'status' => false,
                'message' => __('cp.cannot_be_featured_with_subcategories')
            ], 422);
        }

        $category->is_featured = $category->is_featured === 'yes' ? 'no' : 'yes';
        $category->save();

        return response()->json([
            'status' => true,
            'message' => __('cp.success_message'),
            'is_featured' => $category->is_featured
        ]);
    }


}
