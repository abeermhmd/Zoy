<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use App\Models\{PromoCode, Setting , Country};
use App\Services\PromoCodeService;

class PromoCodeController extends Controller
{
    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->settings = Setting::query()->first();
        $this->promoCodeService = $promoCodeService;
        $this->middleware(function ($request, $next) {
            if (!can('promoCodes')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = PromoCode::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view( 'adminCpanel.promoCodes.home',compact('items'));
    }

    public function create()
    {
        $item = new PromoCode();
        $countries =  Country::active()->get();
        return view('adminCpanel.promoCodes.create' , compact('item','countries'));
    }

    public function store(PromoCodeRequest $request)
    {
        $this->promoCodeService->createPromoCode($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = PromoCode::query()->findOrFail($id);
        $countries = Country::active()->get();
        return view('adminCpanel.promoCodes.edit', compact('item','countries'));
    }

    public function update(PromoCodeRequest $request, $id)
    {
        $item = PromoCode::findOrFail($id);
        $this->promoCodeService->updatePromoCode($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
