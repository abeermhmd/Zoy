<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManualEmailRequest;
use App\Services\ManualEmailService;
use App\Models\{ManualEmail, Setting, User};

class ManualEmailController extends Controller
{
    public function __construct(ManualEmailService $manualEmailService)
    {
        $this->settings = Setting::query()->first();
        $this->users = User::query()->active()->get();
        $this->manualEmailService = $manualEmailService;
        $this->middleware(function ($request, $next) {
            if (!can('notificationManagement')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index()
    {
        $items = ManualEmail::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.manualEmails.home', compact('items'));
    }

    public function create()
    {
        $item = new ManualEmail();
        $users = $this->users;
        return view('adminCpanel.manualEmails.create', compact('item', 'users'));
    }

    public function store(ManualEmailRequest $request)
    {
        $this->manualEmailService->createManualEmail($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = ManualEmail::query()->findOrFail($id);
        $users = $this->users;
        return view('adminCpanel.manualEmails.edit', compact('item', 'users'));
    }

    public function show($id)
    {
        $item = ManualEmail::query()->findOrFail($id);
        $users = $this->users;
        return view('adminCpanel.manualEmails.show', compact('item' ,'users'));
    }

    public function update(ManualEmailRequest $request, $id)
    {
        $item = ManualEmail::findOrFail($id);
        $this->manualEmailService->updateManualEmail($item, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
