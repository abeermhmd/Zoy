<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Requests\EmailTextRequest;
use App\Models\EmailText;
use App\Services\EmailTextService;
use App\Http\Controllers\Controller;

class EmailTextController extends Controller
{

    public function __construct(EmailTextService  $emailTextService)
    {
        $this->emailTextService = $emailTextService;

        $this->middleware(function ($request, $next) {
            if (!can('notificationManagement')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }
    public function index()
    {
        $emailTexts  = EmailText::filter()->get();
        return view('adminCpanel.emailTexts.home', ['emailTexts' => $emailTexts]);
    }
    public function edit($id)
    {
        $item = EmailText::query()->findOrFail($id);
        return view('adminCpanel.emailTexts.edit', ['item' => $item]);
    }


    public function update(EmailTextRequest $request, $id)
    {
        $page = EmailText::query()->findOrFail($id);
        $this->emailTextService->updateEmailText($page , $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
