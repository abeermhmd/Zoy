<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\{Order, Setting, User, UserAddress};
use App\Traits\ImageTrait;
use App\Services\UserService;
use Illuminate\Http\Request;
class UserController extends Controller
{
    use imageTrait;
    Protected $userService;
    public function __construct(UserService $userService)
    {
        $this->settings = Setting::query()->first();
        $this->userService = $userService;
        view()->share(['settings' => $this->settings ]);

        $this->middleware(function ($request, $next) {
            if (!can('users')) { return redirect()->back()->with('permissions', __('cp.no_permission')); }
            return $next($request);
        });
    }

    public function index()
    {
        $items = User::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.users.home', data: compact('items'));
    }

    public function create()
    {
        return view('adminCpanel.users.create');
    }

    public function show($id)
    {
        $item = User::findOrFail($id);
        return view('adminCpanel.users.show', compact('item'));
    }

    public function store(UserRequest $request)
    {
        $this->userService->createUser($request);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('adminCpanel.users.edit', compact('item'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->userService->updateUser($user, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function edit_password($id)
    {
        $item = User::findOrFail($id);
        return view('adminCpanel.users.edit_password', compact('item'));
    }

    public function update_password(UserRequest $request,$id)
    {
        $user = User::findOrFail($id);
        $this->userService->updatePasswordUser($user, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function addresses($id)
    {
        $item = User::findOrFail($id);
        $addresses = UserAddress::filter()->where('user_id', $id)->paginate($this->settings->paginate);
        return view('adminCpanel.users.addresses', [
            'item' => $item,
            'addresses' => $addresses,
        ]);
    }

    public function orders(Request $request, $id)
    {
        $item = User::findOrFail($id);
        $orders = Order::filter()->where('user_id', $id)->paginate($this->settings->paginate);
        return view('adminCpanel.users.orders', [
            'item' => $item,
            'orders' => $orders,
        ]);
    }

    public function showOrder($id, $order)
    {
        $order = Order::where('id', $order)->first();
        $item = User::findOrFail($id);
        return view('adminCpanel.users.showOrder', ['order' => $order, 'item' => $item,]);
    }
}
