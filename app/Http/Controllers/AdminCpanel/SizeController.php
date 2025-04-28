<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\{Size, Setting};
use App\Services\SizeService;

class SizeController extends Controller
{
    public function __construct(SizeService $sizeService)
    {
        $this->settings = Setting::query()->first();
        $this->sizeService = $sizeService;
        $this->middleware(function ($request, $next) {
            if (!can('variants')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Size::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.sizes.home',compact('items'));
    }

    public function create()
    {
         $item = new Size();
        return view('adminCpanel.sizes.create' ,compact('item'));
    }

    public function store(SizeRequest $request)
    {
        $this->sizeService->createSize($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = Size::query()->findOrFail($id);
        return view('adminCpanel.sizes.edit', compact('item'));
    }

    public function update(SizeRequest $request, $id)
    {
        $item = Size::findOrFail($id);
        $this->sizeService->updateSize($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
