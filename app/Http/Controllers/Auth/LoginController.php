<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Notifications\NotificationService;
use App\Models\{EmailText, Setting, User};
use Firebase\JWT\{JWK, JWT};
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, Http, Log, Validator};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ){}

    /**
     * Handle an incoming authentication request for regular users.
     */
    public function login(LoginRequest $request)
    {
        if (Setting::first()->is_alowed_login == 0) {
            if ($request->ajax()) {
                return response()->json(['error' => __('cp.loginStoped')], 400);
            }
            return redirect()->back()->with('error', __('cp.loginStoped'))->withInput();
        }
        $request->validate([
            'recaptcha_token' => 'required',
        ]);

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('recaptcha_token'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success'] || $result['score'] < 0.5) {
            $message = __('website.recaptcha_failed');
            if ($request->ajax()) {
                return response()->json(['error' => $message], 400);
            }
            return redirect()->back()->withErrors(['recaptcha_token' => $message])->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json(['success' => true], 200);
            }

            return redirect()->intended(route('home', absolute: false));
        }

        $message = (app()->getLocale() == 'ar') ? 'بيانات الدخول غير صحيحة' : 'Invalid credentials';
        if ($request->ajax()) {
            return response()->json(['error' => $message], 400);
        }
        return redirect()->back()->withErrors(['email' => $message])->withInput();
    }

    /**
     * Destroy an authenticated session for regular users.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToProvider(Request $request, $provider)
    {
        $validator = Validator::make($request->all(), [
            'introduction' => 'required|in:965,966,968,971,973,974',
            'mobile' => 'required|regex:/^[0-9]{8,15}$/',
            'date_of_birth' => 'required|date|before:today',
            'recaptcha_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('recaptcha_token'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success'] || $result['score'] < 0.5) {
            return response()->json([
                'status' => 'error',
                'errors' => ['recaptcha_token' => __('website.recaptcha_failed')]
            ], 422);
        }

        $request->session()->put('google_signup_data', [
            'introduction' => $request->introduction,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->date_of_birth,
        ]);

        $redirectUrl = Socialite::driver($provider)
            ->scopes(['email', 'profile'])
            ->redirect()
            ->getTargetUrl();

        return response()->json([
            'status' => 'success',
            'redirect' => $redirectUrl,
        ]);
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $signupData = $request->session()->pull('google_signup_data', []);

            if (empty($signupData['introduction']) || empty($signupData['mobile']) || empty($signupData['date_of_birth'])) {
                return redirect()->route('signUpGoogle')
                    ->with('error', __('website.missing_signup_data'))
                    ->withInput();
            }

            $fullMobile = '+' . $signupData['introduction'] . $signupData['mobile'];


            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('social_token', $socialUser->token)
                ->orWhere('email', $socialUser->email)
                ->first();

            if (!$user) {
                $user = new User();
                $user->name = $socialUser->name?? 'Google User';
                $user->email = $socialUser->email;
                $user->password = bcrypt(123456789);
                $user->social_token = $socialUser->token;
                $user->social_type = $provider;
                $user->mobile = $fullMobile;
                $user->date_of_birth = $signupData['date_of_birth'];
                $user->save();
                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request();
                }

                $emailText = EmailText::active()->where('type', 'After_Registration')->first();
                if ($emailText && isset($this->notificationService)) {
                    $emailData = ['to' => $user->email, 'subject' => $emailText->subject];
                    $message = view('website.email', ['item' => $emailText])->render();
                    $this->notificationService->sendNotification($message, $emailData, 'email');
                }
            } else {
                $user->social_token = $socialUser->token;
                $user->social_type = $provider;
                $user->mobile = $fullMobile;
                $user->date_of_birth = $signupData['date_of_birth'];
                $user->save();
            }

            if (isset($user->status) && $user->status !== 'active') {
                return redirect()->route('signUpGoogle')
                    ->with('error', 'website.your_account_not_active');
            }

            Auth::login($user, true);

            return redirect()->route('home');

        } catch (Exception $e) {


            return redirect()->route('signUpGoogle')
                ->with('error', __('website.google_signin_failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * التعامل مع تسجيل الدخول عبر حساب Apple
     */
    public function handleAppleCallback(Request $request)
    {
        try {
            // Validate reCAPTCHA token
            $request->validate([
                'recaptcha_token' => 'required',
            ]);

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('recaptcha_token'),
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();

            if (!$result['success'] || $result['score'] < 0.5) {
                $message = __('website.recaptcha_failed');
                return redirect()->route('signUpApple')
                    ->withErrors(['recaptcha_token' => $message])
                    ->withInput();
            }

            $fullMobile = null;
            if ($request->introduction && $request->mobile) {
                $fullMobile = '+' . $request->introduction . $request->mobile;
            }

            $validated = $request->validate([
                'id_token' => 'required|string',
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'introduction' => 'required|string|in:965,966,968,971,973,974',
                'mobile' => 'required|string|regex:/^[0-9]{8,15}$/',
                'date_of_birth' => 'required|date|before:today',
                'full_mobile' => 'unique:users,mobile,' . ($user->id ?? null),
            ]);

            $appleToken = $request->id_token;

            try {
                $response = Http::get('https://appleid.apple.com/auth/keys');
                $keys = $response->json();
                $jwt = JWT::decode($appleToken, JWK::parseKeySet($keys));

                $email = $request->email ?? $jwt->email;
                if (empty($email)) {
                    return redirect()->route('signup')
                        ->with('error', __('website.email_required'));
                }
                $appleUserId = $jwt->sub;
            } catch (Exception $e) {
                Log::error('Apple JWT decode error: ' . $e->getMessage());
                return redirect()->route('signup')
                    ->with('error', __('website.apple_signin_failed') . ': ' . $e->getMessage());
            }

            $user = User::where('apple_token', $appleUserId)
                ->orWhere('email', $email)
                ->first();

            if (!$user) {
                $user = new User();
                $user->name = $request->name ?? 'Apple User';
                $user->email = $email;
                $user->password = bcrypt(123456789);
                $user->apple_token = $appleUserId;
                $user->social_type = 'apple';
                $user->mobile = $fullMobile;
                $user->date_of_birth = $request->date_of_birth;
                if (method_exists($this, 'getUniqueReferralCode')) {
                    $user->referral_code = $this->getUniqueReferralCode();
                }
                $user->save();

                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request(); // إرسال الاستجابة إلى العميل أولًا
                }
                $emailText = EmailText::active()->where('type', 'After_Registration')->first();
                if ($emailText && isset($this->notificationService)) {
                    $emailData = ['to' => $user->email, 'subject' => $emailText->subject];
                    $message = view('website.email', ['item' => $emailText])->render();
                    $this->notificationService->sendNotification($message, $emailData, 'email');
                }
            } else {
                $user->apple_token = $appleUserId;
                $user->mobile = $fullMobile ?? $user->mobile;
                $user->date_of_birth = $request->date_of_birth ?? $user->date_of_birth;
                $user->save();
            }

            if (isset($user->status) && $user->status !== 'active') {
                return redirect()->route('signUpApple')
                    ->with('error', __('website.your_account_not_active'));
            }

            Auth::login($user, true);
            return redirect()->intended(route('home', absolute: false));
        } catch (ValidationException $e) {
            return redirect()->route('signUpApple')
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            Log::error('Apple login error: ' . $e->getMessage());
            return redirect()->route('signUpApple')
                ->with('error', __('website.apple_signin_failed') . ': ' . $e->getMessage());
        }
    }

    protected function getUniqueReferralCode()
    {
        $referralCode = Str::random(8);
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = Str::random(8);
        }
        return $referralCode;
    }
}
