<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Models\{Newsletter, Setting};
use App\Services\NewsletterService;

class NewsletterController extends Controller
{
    public function __construct(NewsletterService $newsletterService)
    {
        $this->settings = Setting::query()->first();
        $this->newsletterService = $newsletterService;
        $this->middleware(function ($request, $next) {
            if (!can('newsletterManagement')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Newsletter::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view( 'adminCpanel.newsletters.home',compact('items'));
    }

    public function create()
    {
        $item = new Newsletter();
        return view('adminCpanel.newsletters.create' , compact('item'));
    }

    public function store(NewsletterRequest $request)
    {
        $this->newsletterService->createNewsletter($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Newsletter::query()->findOrFail($id);
        return view('adminCpanel.newsletters.edit', compact('item'));
    }
    public function show($id)
    {
        $item = Newsletter::query()->findOrFail($id);
        return view('adminCpanel.newsletters.show', compact('item'));
    }

    public function update(NewsletterRequest $request, $id)
    {
        $item = Newsletter::findOrFail($id);
        $this->newsletterService->updateNewsletter($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
