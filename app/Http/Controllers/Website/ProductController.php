<?php

namespace App\Http\Controllers\Website;
use App\Models\{Setting,Language ,Product,Category };
use App\Http\Controllers\Controller;
use Route;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::query()->first();
        $this->paginate = $this->settings->website_paginate;
    }

    public function products($category_id)
    {
        $category = Category::findOrFail($category_id);
        $products = Product::active()->where('category_id' , $category_id)->paginate($this->paginate);
        $counts = Product::active()->where('category_id' , $category_id)->count();

      if (request()->ajax()) {
            $is_more = 'yes';
            if ($products->count() < @$this->paginate) {
                $is_more = 'no';
            }
            $view = view('website.productsList')->with(['products' => $products])->render();
            return response()->json(['html' => $view, 'is_more' => $is_more , 'total'=>$products->total()]);
        }

        return view('website.products',compact('products' ,'category','counts'));
    }

    public function search()
    {
        if(request('name') == ''){
            return redirect()->back();
        }
        $products = Product::active()->filter()->orderBy('id')->paginate($this->paginate);

      if (request()->ajax()) {
            $is_more = 'yes';
            if ($products->count() < @$this->paginate) {
                $is_more = 'no';
            }
            $view = view('website.productsList')->with(['products' => $products])->render();
            return response()->json(['html' => $view, 'is_more' => $is_more , 'total'=>$products->total()]);
        }

        return view('website.search',compact('products'));
    }

    public function productDetails($product_id)
    {
      $product = Product::with('images','similarProducts')->findOrFail($product_id);
      return view('website.productDetails' ,compact('product'));
    }

}

