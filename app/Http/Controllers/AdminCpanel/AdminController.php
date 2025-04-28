<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Requests\AdminRequest;
use App\Models\{Admin, Permission, Setting, UserPermission};
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->settings = Setting::first();
        $this->adminService = $adminService;

        // Apply middleware to all methods except the last four
        $this->middleware(function ($request, $next) {
            if (!can('admins')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        })->except(['editMyProfile', 'updateProfile', 'changeMyPassword', 'updateMyPassword']);
    }

    public function index()
    {
        $items = Admin::filter()->where('id', '>', 1)
            ->orderBy('id', 'desc')
            ->paginate($this->settings->dashboard_paginate);

        return view('adminCpanel.admins.home', compact('items'));
    }

    public function create()
    {
        $users = Admin::get();
        $role = Permission::get();
        return view('adminCpanel.admins.create', compact('users', 'role'));
    }

    public function store(AdminRequest $request)
    {
        $this->adminService->createAdmin($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = Admin::findOrFail($id);
        $role = Permission::get();
        // جلب أذونات المستخدم مباشرة باستخدام optional() لتجنب الشروط الزائدة
        $userRole = optional(UserPermission::where('user_id', $item->id)->first());
        $userRoleItem = $userRole->permission ? explode(',', $userRole->permission) : [];

        return view('adminCpanel.admins.edit', compact('item', 'role', 'userRoleItem'));
    }

    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $this->adminService->updateAdmin($admin, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function edit_password($id)
    {
        $item = Admin::findOrFail($id);
        return view('adminCpanel.admins.edit_password', compact('item'));
    }

    public function update_password(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $this->adminService->updatePasswordAdmin($admin, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function editMyProfile()
    {
        $item = Admin::findOrFail(auth()->guard('admin')->user()->id);
        return view('adminCpanel.admins.edit_profile', compact('item'));
    }

    public function updateProfile(AdminRequest $request)
    {
        $admin = Admin::findOrFail(auth()->guard('admin')->user()->id);
        $this->adminService->updateProfileAdmin($admin, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function changeMyPassword()
    {
        $item = Admin::findOrFail(auth()->guard('admin')->user()->id);
        return view('adminCpanel.admins.changeMyPassword', compact('item'));
    }

    public function updateMyPassword(AdminRequest $request)
    {
        $admin = Admin::findOrFail(auth()->guard('admin')->user()->id);
        $this->adminService->updatePasswordAdmin($admin, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
