<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Notifications\NotificationService;
use App\Services\UserService;
use App\Models\{EmailText, Order, Setting, Country, User, UserAddress, Product, Favorite};
use Auth;
use Session;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService , NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->settings = Setting::first();
        $this->notificationService = $notificationService;

    }

    public function signIn()
    {

        return view('website.signIn');
    }

    public function signUpApple()
    {
        return view('website.signUpApple');
    }
    public function signUpGoogle()
    {
        return view('website.signUpGoogle');
    }

    public function forgotPassword()
    {

        return view('website.forgotPassword');
    }


    public function changePassword()
    {
        return view('website.changePassword');
    }

    public function changePasswordPost(UserRequest $request)
    {
        $user = User::findOrFail(auth('web')->user()->id);
        $result = $this->userService->changePassword(
            $user,
            $request->old_password,
            $request->new_password
        );

        return response()->json($result);
    }

    public function myAccount()
    {
        return view('website.myAccount');
    }

    public function updateProfile(UserRequest $request)
    {
        $updateUser = $this->userService->updateUser(auth('web')->user(), $request);

        if ($updateUser) {
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 300, 'message' => $message
            ]);
        } else {
            $message = __('api.whoops');
            return response()->json(['status' => false, 'code' => 500, 'message' => $message
            ]);
        }
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth('web')->id())->where('payment_status', 1)->orderByDesc('id')->get();
        return view('website.myOrders', compact('orders'));
    }

    public function orderDetails($order_id)
    {
        $order = Order::where('user_id', auth('web')->id())->where('payment_status', 1)->findOrFail($order_id);
        return view('website.orderDetails', compact('order'));
    }

    public function myCards()
    {
        return view('website.myCards');
    }

    public function myFavorite()
    {
        $ids = Favorite::where('user_id', auth('web')->id())->orderByDesc('id')->pluck('product_id');
        $products = Product::active()->whereIn('id', $ids)->get();
        return view('website.myFavorite', compact('products'));
    }

    public function signUp()
    {
        return view('website.signUp');
    }

    public function register(UserRequest $request)
    {
        if ($this->settings->is_alowed_register == 0) {
            return response()->json([
                'code' => 201,
                'error' => __('website.registerStoped')]);
        }

        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY', '6LeqtR0rAAAAAMwnJo5WxGsNXStxuLYPsQVLSgLF');
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $request->recaptcha_token,
            'remoteip' => $request->ip()
        ])->json();

        if (!isset($recaptchaResponse['success']) || !$recaptchaResponse['success'] ||
            (isset($recaptchaResponse['score']) && $recaptchaResponse['score'] < 0.5)) {
            return response()->json([
                'success' => false,
                'code' => 201,
                'error' => __('website.recaptcha_verification_failed', 'فشل التحقق الأمني، يرجى تحديث الصفحة والمحاولة مرة أخرى')
            ]);
        }
        $newUser = $this->userService->createUser($request);

        Auth::guard()->login($newUser);

        $emailText = EmailText::active()->where('type', 'After_Registration')->first();
        if ($emailText) {
            $emailData = [
                'to' => $newUser->email,
                'subject' => $emailText->subject,
            ];
            $message = view('website.email', ['item' => $emailText])->render();
            $this->notificationService->sendNotification($message, $emailData, 'email');
        }
        return response()->json(['code' => 200, 'message' => __('api.ok'), 'redirect_url' => route('home')]);
    }

    public function myAddresses()
    {
        $data['addresses'] = UserAddress::where('user_id', auth('web')->id())->orderByDesc('id')->get();
        $data['countries'] = Country::active()->get();
        return view('website.myAddresses', compact('data'));
    }

    public function addressDetails($id)
    {
        $data['item'] = UserAddress::where('user_id', auth('web')->id())->findOrFail($id);
        $data['countries'] = Country::active()->get();
        $view = view('website.editAddress', compact('data'))->render();
        return response()->json(['status' => true, 'code' => 200, 'html' => $view]);
    }

    public function deleteAddress($id)
    {
        UserAddress::where('user_id', auth('web')->id())->findOrFail($id)->delete();
        $totalAddress = UserAddress::where('user_id', auth('web')->id())->count();
        return response()->json(['status' => true, 'totalAddress' => $totalAddress, 'code' => 200]);
    }

    public function addAddress(UserRequest $request)
    {
        $newAddress = $this->userService->addAddressUser($request);

        if ($newAddress) {
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 300, 'message' => $message
            ]);
        } else {
            $message = __('api.whoops');
            return response()->json(['status' => false, 'code' => 500, 'message' => $message
            ]);
        }
    }

    public function updateAddress(UserRequest $request, $id)
    {
        $UserAddress = UserAddress::where('user_id', auth('web')->id())->findOrFail($id);
        $updateAddress = $this->userService->updateAddressUser($UserAddress, $request);

        if ($updateAddress) {
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 300, 'message' => $message
            ]);
        } else {
            $message = __('api.whoops');
            return response()->json(['status' => false, 'code' => 500, 'message' => $message
            ]);
        }
    }


}
