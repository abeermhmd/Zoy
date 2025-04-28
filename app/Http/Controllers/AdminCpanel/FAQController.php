<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Models\{Faq, Setting};
use App\Services\FAQService;

class FAQController extends Controller
{
    public function __construct(FAQService $faqsService)
    {
        $this->settings = Setting::query()->first();
        $this->faqsService = $faqsService;
        $this->middleware(function ($request, $next) {
            if (!can('faqs')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Faq::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.faqs.home',compact('items'));
    }

    public function create()
    {
         $item = new Faq();
        return view('adminCpanel.faqs.create' ,compact('item'));
    }

    public function store(FAQRequest $request)
    {
        $this->faqsService->createFaqs($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = Faq::query()->findOrFail($id);
        return view('adminCpanel.faqs.edit', compact('item'));
    }

    public function update(FAQRequest $request, $id)
    {
        $item = Faq::findOrFail($id);
        $this->faqsService->updateFaqs($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
