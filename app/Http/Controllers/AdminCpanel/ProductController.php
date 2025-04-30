<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\{Product, Setting, Category, Color, Size};
use App\Services\ProductService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function __construct(ProductService $productService)
    {
        $this->settings = Setting::query()->first();
        $this->productService = $productService;
        $this->middleware(function ($request, $next) {
            if (!can('products')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index()
    {
        $items = Product::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        $categories = Category::where(function ($query) {
                $query->whereNull('parent_id')->whereDoesntHave('subcategories')
                    ->orWhereNotNull('parent_id');
            })->orderBy('id')->get();
        return view('adminCpanel.products.home', compact('items', 'categories'));
    }

    public function create()
    {
        $item = new Product();
        $categories = Category::active()
            ->where(function ($query) {
                $query->whereNull('parent_id')->whereDoesntHave('subcategories')
                    ->orWhereNotNull('parent_id');
            })->orderBy('id')->get();
        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        $similar_products = Product::active()->get();
        return view('adminCpanel.products.create', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request);

        if ($product->has_variants) {
            return redirect()->route('admins.products.quantites', $product->id)
                ->with('status', __('cp.create'));
        }

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function show($id)
    {
        $item = Product::with(['productColorSizes.images'])->findOrFail($id);
        $categories = Category::active()->where(function ($query) {
            $query->whereNull('parent_id')->whereDoesntHave('subcategories')
                ->orWhereNotNull('parent_id');
        })->orderBy('id')->get();

        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        $similar_products = Product::active()->where('id', '!=', $id)->get();

        return view('adminCpanel.products.show', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }

    public function edit($id)
    {
        $item = Product::with(['productColorSizes.images'])->findOrFail($id);
        $categories = Category::active()->where(function ($query) {
            $query->whereNull('parent_id')->whereDoesntHave('subcategories')
                ->orWhereNotNull('parent_id');
        })->orderBy('id')->get();

        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        $similar_products = Product::active()->where('id', '!=', $id)->get();

        return view('adminCpanel.products.edit', compact('item', 'categories', 'colors', 'sizes', 'similar_products'));
    }

    public function update(ProductRequest $request, $id)
    {
        $item = Product::findOrFail($id);
        $this->productService->updateProduct($item, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function quantites($id)
    {
        $item = Product::where('has_variants', 1)->with('productColorSizes')->findOrFail($id);
        return view('adminCpanel.products.quantites', compact('item'));
    }

    public function updateQuantites(ProductRequest $request, $id)
    {
        $item = Product::where('has_variants', 1)->findOrFail($id);
        $this->productService->updateProductQuantities($item, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }


}
