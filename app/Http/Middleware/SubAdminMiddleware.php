<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class SubAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard='subadmin')
    {
        $adminAuth = Auth::guard($guard)->user();
        if ($adminAuth && $adminAuth->status == 'not_active') {
            Auth::guard($guard)->logout();
            $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account not active';
            return redirect('/subadmin/login')->withErrors([$message]);
        }
        
        if(! Auth::guard($guard)->check()){
            return redirect('subadmin/login');
        }
        return $next($request);
    }
}
