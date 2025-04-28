<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\{Color, Setting};
use App\Services\ColorService;

class ColorController extends Controller
{
    public function __construct(ColorService $colorService)
    {
        $this->settings = Setting::query()->first();
        $this->colorService = $colorService;
        $this->middleware(function ($request, $next) {
            if (!can('variants')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Color::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.colors.home',compact('items'));
    }

    public function create()
    {
         $item = new Color();
        return view('adminCpanel.colors.create' ,compact('item'));
    }

    public function store(ColorRequest $request)
    {
        $this->colorService->createColor($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = Color::query()->findOrFail($id);
        return view('adminCpanel.colors.edit', compact('item'));
    }

    public function update(ColorRequest $request, $id)
    {
        $item = Color::findOrFail($id);
        $this->colorService->updateColor($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
