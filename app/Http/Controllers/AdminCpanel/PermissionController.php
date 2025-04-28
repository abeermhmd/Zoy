<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\{Permission, Setting};
use App\Services\PermissionService;

class PermissionController extends Controller
{
    public function __construct(PermissionService $permissionService)
    {
        $this->settings = Setting::query()->first();
        $this->permissionService = $permissionService;
        $this->middleware(function ($request, $next) {
            if (!can('permissions')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $items = Permission::query()->filter()->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.permissions.home',compact('items'));
    }

    public function create()
    {
        return view('adminCpanel.permissions.create' );
    }

    public function store(PermissionRequest $request)
    {
        $this->permissionService->createPermission($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Permission::query()->findOrFail($id);
        return view('adminCpanel.permissions.edit', compact('item'));
    }

    public function update(PermissionRequest $request, $id)
    {
        $item = Permission::findOrFail($id);
        $this->permissionService->updatePermission($item , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
