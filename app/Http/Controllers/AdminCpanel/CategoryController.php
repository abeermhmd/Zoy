<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\{Category, Setting};
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(CategoryService $categoryService)
    {
        $this->settings = Setting::query()->first();
        $this->categoryService = $categoryService;
        $this->middleware(function ($request, $next) {
            if (!can('categories')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Category::query()->where('parent_id' , null)->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.categories.home',compact('items'));
    }

    public function create()
    {
        $item = new Category();
        return view('adminCpanel.categories.create' , compact('item'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->createCategory($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Category::query()->findOrFail($id);
        return view('adminCpanel.categories.edit', compact('item'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $item = Category::findOrFail($id);
        $this->categoryService->updateCategory($item , $request);
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
