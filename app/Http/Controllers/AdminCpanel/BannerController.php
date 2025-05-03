<?php

namespace App\Http\Controllers\AdminCpanel;

use App\DataTransferObjects\Banners\{AdPopUpDataTransfer,
    BannerAdDataTransfer,
    BannerDataTransfer,
    BannerFilterDataTransfer};
use App\Contracts\{BannerContract , CategoryContract};
use App\DataTransferObjects\Categories\CategoryFilterDataTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\{Category ,Product};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function __construct(
        protected readonly BannerContract $bannerContract,
        protected readonly CategoryContract $categoryContract){}

    public function index(): View
    {
        $filters = BannerFilterDataTransfer::fromRequest(request());
        $items = $this->bannerContract->getBanners($filters);
        return view('adminCpanel.banners.home', compact('items'));
    }

    public function create(): View
    {
        $mainCategoriesFilter = new CategoryFilterDataTransfer( isPaginate: false, status: 'active');
        $main_categories =  $this->categoryContract->getCategories($mainCategoriesFilter);
        $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
        $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.create', compact('main_categories' ,'sub_categories' ,'products'));
    }


    public function store(BannerRequest $request ): RedirectResponse
    {
        $bannerDto = BannerDataTransfer::fromRequest($request);
        $this->bannerContract->createBanner($bannerDto);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id): View
    {
        $item = $this->bannerContract->getBanner($id);
        $mainCategoriesFilter = new CategoryFilterDataTransfer( isPaginate: false,status: 'active');
        $main_categories =  $this->categoryContract->getCategories($mainCategoriesFilter);
        $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
        $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.edit', compact('item','main_categories' ,'sub_categories' ,'products'));
    }

    public function update(BannerRequest $request, $id) : RedirectResponse
    {
        $banner = $this->bannerContract->getBanner($id);
        $bannerDto = BannerDataTransfer::fromRequest($request);
        $this->bannerContract->updateBanner($banner, $bannerDto);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function bannerAd(): View
    {
        $mainCategoriesFilter = new CategoryFilterDataTransfer( isPaginate: false,
            status: 'active'
        );

        $main_categories =  $this->categoryContract->getCategories($mainCategoriesFilter);
         $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
         $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.bannerAd', compact('main_categories' ,'sub_categories' ,'products'));
    }

    public function bannerAdUpdate(BannerRequest $request): RedirectResponse
    {
        $bannerAdDto = BannerAdDataTransfer::fromRequest($request);
        $this->bannerContract->bannerAdUpdate($bannerAdDto);
        return redirect()->back()->with('status', __('cp.update'));
    }
    public function adPopUp(): View
    {
         $main_categories = Category::active()->where('parent_id' , null)->get();
         $sub_categories = Category::active()->where('parent_id' , '!=',null)->get();
         $products = Product::active()->orderByDesc('id')->get();
        return view('adminCpanel.banners.adPopUp', compact('main_categories' ,'sub_categories' ,'products'));
    }

    public function adPopUpUpdate(BannerRequest $request): RedirectResponse
    {
        $adPopUpDto = AdPopUpDataTransfer::fromRequest($request);
        $this->bannerContract->adPopUpUpdate($adPopUpDto);
        return redirect()->back()->with('status', __('cp.update'));
    }

}
