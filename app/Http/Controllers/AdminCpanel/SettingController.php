<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;
    private $setting;
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
        $this->setting = Setting::query()->first();
        view()->share(['item' => $this->setting]);

        $this->middleware(function ($request, $next) {
            if (!can('settings')) {
            return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index()
    {
        return view('adminCpanel.settings.edit');
    }

    public function system_maintenance()
    {
        return view('adminCpanel.settings.editMaintanense');
    }

    public function system_seo()
    {
        return view('adminCpanel.settings.editSeo');
    }

    public function update(SettingRequest $request , $id = 1)
    {
        $this->settingService->updateSetting($this->setting, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function update_system_maintenance(Request $request)
    {
        $this->settingService->updateSystemMaintenance($this->setting, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function update_system_seo(Request $request)
    {
        $this->settingService->updateSystemSeo($this->setting, $request);
        return redirect()->back()->with('status', __('cp.update'));
    }
}
