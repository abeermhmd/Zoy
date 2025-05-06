<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Contracts\SizeContract;
use App\DataTransferObjects\Sizes\{SizeDataTransfer,SizeFilterDataTransfer};
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;

class SizeController extends Controller
{
    public function __construct(protected SizeContract $sizeContract)
    {
        $this->middleware(function ($request, $next) {
            if (!can('variants')) { return redirect()->back()->with('permissions', __('cp.no_permission'));}
            return $next($request);
        });
    }

    public function index()
    {
        $dtoFilter = SizeFilterDataTransfer::fromRequest(request());
        $items = $this->sizeContract->getSizes($dtoFilter);
        return view('adminCpanel.sizes.home',compact('items'));
    }

    public function create()
    {
        return view('adminCpanel.sizes.create');
    }

    public function store(SizeRequest $request)
    {
        $dtoSize = SizeDataTransfer::fromRequest($request);
        $this->sizeContract->createSize($dtoSize);
        return redirect()->back()->with('status', __('cp.create'));
    }

    public function edit($id)
    {
        $item = $this->sizeContract->getSize($id);
        return view('adminCpanel.sizes.edit', compact('item'));
    }

    public function update(SizeRequest $request, $id)
    {
        $item = $this->sizeContract->getSize($id);
        $dtoSize = SizeDataTransfer::fromRequest($request);
        $this->sizeContract->updateSize($item , $dtoSize);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
