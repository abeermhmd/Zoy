<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $settings;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkOut(OrderRequest $request)
    {
        return response()->json($this->orderService->checkOut($request));
    }

    public function checkPayment(Request $request, $order_id)
    {
        $result = $this->orderService->checkPayment($request, $order_id);
        return redirect($result['redirect']);
    }

    public function successPayment($order_id)
    {
        $query = Order::query();
        if (auth('web')->check()) {
            $query->where('user_id', auth('web')->id());
        } else {
            $query->where('user_key', Session::get('cart.ids'));
        }
        $order = $query->where('payment_status', 1)->findOrFail($order_id);
        return view('website.success' , compact('order'));

    }

    public function failPayment()
    {
        return view('website.error');
    }
}
