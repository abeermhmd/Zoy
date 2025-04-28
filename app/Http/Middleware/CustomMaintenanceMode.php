<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class CustomMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $setting = Setting::first(); // Fetch the settings (optimize with caching if needed)
        $isAdminRoute = str_contains($request->path(), 'admin');

        if ($setting->is_maintenance_mode && !$isAdminRoute) {
            return response()->view('errors.maintenancePage', [], 503);
//            throw new ServiceUnavailableHttpException(null, 'Site is under maintenance.');
        }

        return $next($request);
    }
}
