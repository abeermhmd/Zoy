<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\{Category, Setting};
use App\Services\CategoryService;

class SubCategoryController extends Controller
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
        $items = Category::query()->filter()->where('parent_id' ,'!=' ,null)->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        $categories = Category::query()->where('parent_id'  ,null)->orderBy('id', 'desc')->get();
        return view('adminCpanel.subCategories.home',compact('items','categories'));
    }

    public function create()
    {
        $item = new Category();
        $mainCategories = Category::active()->where('parent_id' , null)->get();
        return view('adminCpanel.subCategories.create' , compact('item' ,'mainCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->createSubCategory($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Category::query()->findOrFail($id);
        $mainCategories = Category::active()->where('parent_id' , null)->get();
        return view('adminCpanel.subCategories.edit', compact('item','mainCategories'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $item = Category::findOrFail($id);
        $this->categoryService->updateSubCategory($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
