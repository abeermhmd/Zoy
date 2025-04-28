<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Requests\ContactRequest;
use App\Models\{Contact,Setting};
use App\Services\ContactService;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    protected $contactService ;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
        $this->settings = Setting::query()->first();

        $this->middleware(function ($request, $next) {
         if(!can('contact')){
             return redirect()->back()->with('permissions', __('cp.no_permission'));
        }
        return $next($request);
        });
    }

    public function index()
    {
        $items = Contact::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->dashboard_paginate);
        return view('adminCpanel.contacts.home', compact('items'));
    }

    public function viewMessage($id)
    {
        $item =  $this->contactService->findById($id);
        return view('adminCpanel.contacts.message', compact('item'));
    }

    public function update(ContactRequest $request, $id)
    {
        // $contact = Contact::findOrFail($id);
        $contact = $this->contactService->findById($id);
         $this->contactService->updateContact($contact , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
