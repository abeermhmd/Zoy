<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Contracts\ColorContract;
use App\DataTransferObjects\Colors\{ColorDataTransfer,ColorFilterDataTransfer};
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;

class ColorController extends Controller
{
    public function __construct(protected ColorContract $colorContract)
    {
        $this->middleware(function ($request, $next) {
            if (!can('variants')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
       $dtoFilterColor = ColorFilterDataTransfer::fromRequest(request());
       $items = $this->colorContract->getColors($dtoFilterColor);
       return view('adminCpanel.colors.home',compact('items'));
    }

    public function create()
    {
        return view('adminCpanel.colors.create');
    }

    public function store(ColorRequest $request)
    {
        $dtoColor = ColorDataTransfer::fromRequest($request);
        $this->colorContract->createColor($dtoColor);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = $this->colorContract->getColor($id);
        return view('adminCpanel.colors.edit', compact('item'));
    }

    public function update(ColorRequest $request, $id)
    {
        $item = $this->colorContract->getColor($id);
        $dtoColor = ColorDataTransfer::fromRequest($request);
        $this->colorContract->updateColor($item , $dtoColor);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
