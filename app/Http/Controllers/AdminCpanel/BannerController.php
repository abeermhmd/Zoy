<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Services\Actions\DataTransferObjects\BannerFilterDataTransfer;
use App\Models\{Banner , Setting ,Category ,Product};
use App\Services\BannerService;

class BannerController extends Controller
{
    public function __construct(
        protected readonly BannerService $bannerService,
    ){
        $this->settings = Setting::query()->first();
    }

    public function index()
    {
        $items = Banner::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.banners.home', compact('items'));
    }

    public function create()
    {
        $main_categories = Category::active()->where('parent_id' , null)->get();
        $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
        $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.create', compact('main_categories' ,'sub_categories' ,'products'));
    }


    public function store(BannerRequest $request)
    {
        $this->bannerService->createBanner($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = Banner::query()->findOrFail($id);
        $main_categories = Category::active()->where('parent_id' , null)->get();
        $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
        $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.edit', compact('item','main_categories' ,'sub_categories' ,'products'));
    }

    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $this->bannerService->updateBanner($banner , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function bannerAd()
    {
         $main_categories = Category::active()->where('parent_id' , null)->get();
         $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
         $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.bannerAd', compact('main_categories' ,'sub_categories' ,'products'));
    }

    public function bannerAdUpdate(BannerRequest $request)
    {
        $this->bannerService->bannerAdUpdate($request);
        return redirect()->back()->with('status', __('cp.update'));
    }
    public function adPopUp()
    {
         $main_categories = Category::active()->where('parent_id' , null)->get();
         $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
         $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.adPopUp', compact('main_categories' ,'sub_categories' ,'products'));
    }

    public function adPopUpUpdate(BannerRequest $request)
    {
        $this->bannerService->adPopUpUpdate($request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
