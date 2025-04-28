<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Services\Notifications\NotificationService;
use Illuminate\Http\Request;
use App\Models\{EmailText, Language, Order, Setting, User};

class OrderController extends Controller
{
    public function __construct(NotificationService $notificationService)
    {
        $this->locales = Language::all();
        $this->settings = Setting::first();
        $this->notificationService = $notificationService;
        view()->share(['locales' => $this->locales, 'setting' => $this->settings,]);
        $this->middleware(function ($request, $next) {
            if (!can('orders')) {
                return redirect()->back()->with('permissions', __('cp.no_permission'));
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        updateFirebase('reset');
        $items = Order::query()->filter()->orderBy('id', 'desc')->where('payment_status', 1)->paginate($this->settings->paginate);
        return view('adminCpanel.orders.home', compact('items'));
    }

    public function edit($id)
    {
        $order = Order::where('payment_status', 1)->with('products')->findOrFail($id);
        return view('adminCpanel.orders.edit', compact('order'));
    }

    public function show($id)
    {
        $order = Order::where('payment_status', 1)->with('products')->findOrFail($id);
        return view('adminCpanel.orders.invoice', compact('order'));
    }

    public function update(Request $request, $id)
    {
        //status:	0->Placed , 1->On the Way , 2->Delivered , 3->Canceled
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        $email = $order->email ?? $order->user->email;

        if ($request->status == 3) {
            $type = 'Uncompleted_orders';
        } else {
            $type = 'Order_status_updated';
        }

        $emailText = EmailText::active()->where('type', $type)->first();
        if ($emailText) {
            $emailData = [
                'to' => $email,
                'subject' => $emailText->subject,
            ];
            $message = view('website.email', ['item' => $emailText])->render();
            $this->notificationService->sendNotification($message, $emailData, 'email');
        }

        return redirect()->back()->with('status', __('cp.update'));
    }


}


