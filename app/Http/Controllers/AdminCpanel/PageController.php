<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\PageService;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function __construct(PageService  $pageService)
    {
        $this->pageService = $pageService;

        $this->middleware(function ($request, $next) {
            if (!can('pages')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }
    public function index()
    {
        $pages = Page::get();
        return view('adminCpanel.pages.home', ['pages' => $pages]);
    }

      public function create()
    {
        return view('adminCpanel.pages.create');
    }


    public function store(PageRequest $request)
    {
        $this->pageService->createPage($request);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Page::query()->findOrFail($id);
        return view('adminCpanel.pages.edit', ['item' => $item]);
    }


    public function update(PageRequest $request, $id)
    {
        $page = Page::query()->findOrFail($id);
        $this->pageService->updatePage($page , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
