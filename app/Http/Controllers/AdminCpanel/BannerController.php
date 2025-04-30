<?php

namespace App\Http\Controllers\AdminCpanel;

use App\DataTransferObjects\Banners\{AdPopUpDataTransfer,BannerAdDataTransfer , BannerDataTransfer};
use App\Contracts\BannerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\{Banner , Setting ,Category ,Product};

class BannerController extends Controller
{
    public function __construct(
        protected readonly BannerContract $bannerContract,
    ){
        $this->settings = Setting::query()->first();
    }

    public function index()
    {
        $items = $this->bannerContract->getBanners([request()->all() , 'isPaginate'=>true]);
        return view('adminCpanel.banners.home', compact('items'));
    }

    public function create()
    {
        $main_categories = Category::active()->where('parent_id' , null)->get();
        $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
        $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.create', compact('main_categories' ,'sub_categories' ,'products'));
    }


    public function store(BannerRequest $request )
    {
        $bannerDto = BannerDataTransfer::fromRequest($request);
        $this->bannerContract->createBanner($bannerDto);
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
        $banner = $this->bannerContract->getBanner($id);
        $bannerDto = BannerDataTransfer::fromRequest($request);
        $this->bannerContract->updateBanner($banner, $bannerDto);
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
        $bannerAdDto = BannerAdDataTransfer::fromRequest($request);
        $this->bannerContract->bannerAdUpdate($bannerAdDto);
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
        $adPopUpDto = AdPopUpDataTransfer::fromRequest($request);
        $this->bannerContract->adPopUpUpdate($adPopUpDto);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
