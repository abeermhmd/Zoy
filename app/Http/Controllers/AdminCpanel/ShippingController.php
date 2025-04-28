<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\{Country,City, Setting};
use App\Services\ShippingService;

class ShippingController extends Controller
{
    public function __construct(ShippingService $shippingService)
    {
        $this->settings = Setting::query()->first();
        $this->shippingService = $shippingService;
        $this->middleware(function ($request, $next) {
            if (!can('shippingManagement')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function content()
    {
        $item = $this->settings;
        return view('adminCpanel.shippings.editContent',compact('item'));
    }

    public function updateContent(ShippingRequest $request)
    {
        $this->shippingService->updateContent($this->settings,$request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function shippingPrices()
    {
        $countries = Country::active()->where('id' , '!=' , 1)->get();
        $cities = City::active()->where('country_id' , 1)->get();
        return view('adminCpanel.shippings.editPrices', compact('countries' ,'cities'));
    }

    public function updateShippingPrices(ShippingRequest $request)
    {
        $this->shippingService->updateShippingPrices($request->all());
        return redirect()->back()->with('status', __('cp.update'));
    }
}
