<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('adminCpanel.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = Admin::where('email',$request->email)->first();

        if($user){
            if($user->status != 'active'){
                Auth::logoutOtherDevices($request->password);
                $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account not active';
                return redirect()->back()->withErrors([$message]);
            }
        }

        $request->authenticate('admin');
        $request->session()->regenerate();
        return redirect()->intended(route('admins.admin.home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
