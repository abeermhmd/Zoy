<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Models\{Subscriber, Setting};
use App\Services\SubscriberService;

class SubscriberController extends Controller
{
    public function __construct(SubscriberService $subscriberService)
    {
        $this->settings = Setting::query()->first();
        $this->subscriberService = $subscriberService;
        $this->middleware(function ($request, $next) {
            if (!can('newsletterManagement')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Subscriber::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view( 'adminCpanel.subscribers.home',compact('items'));
    }

    public function create()
    {
        $item = new Subscriber();
        return view('adminCpanel.subscribers.create' , compact('item'));
    }

    public function store(SubscriberRequest $request)
    {
        $this->subscriberService->createSubscriber($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Subscriber::query()->findOrFail($id);
        return view('adminCpanel.subscribers.edit', compact('item'));
    }

    public function update(SubscriberRequest $request, $id)
    {
        $item = Subscriber::findOrFail($id);
        $this->subscriberService->updateSubscriber($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
