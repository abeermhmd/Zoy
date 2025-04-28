<?php

namespace App\Services;
use App\Models\{Cart, City, Country, Order, OrderProduct,
    Product, ProductColorSize, PromoCode, PromoCodeCountry, Setting, UserAddress };
use Illuminate\Support\Facades\{DB, Session};
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Notifications\NotificationService;

class OrderService
{
    private $settings;
    private $paymentGateway;
    private $notificationService;

    public function __construct(PaymentGatewayInterface $paymentGateway, NotificationService $notificationService)
    {
        $this->settings = Setting::first();
        $this->paymentGateway = $paymentGateway;
        $this->notificationService = $notificationService;
    }

    public function checkOut($data)
    {
        return DB::transaction(function () use ($data) {
            if ($this->settings->is_alowed_order == 0) {
                return ['status' => false, 'code' => 442, 'message' => __('website.createOrderStoped')];
            }

            $myNewCart = $this->getCartQuery()->get();
            if ($myNewCart->isEmpty()) {
                return ['status' => false, 'code' => 201, 'message' => __('website.cartEmpty')];
            }

            if ($data->code_name && $data->code_name != null){
                $promo =  $this->validatePromoCode($data->code_name, $this->getCountryId($data));
                if (isset($promo['error'])) {
                    return $promo['error'];
                }
            }
            $totals = $this->calculateTotals($myNewCart, $data);
            if (isset($totals['error'])) {
                return $totals['error'];
            }

            $order = $this->createOrder($data, $totals, $myNewCart);
            $this->createOrderProducts($order, $myNewCart);

            $payment = $this->paymentGateway->payment(
                $order->total,
                $order->id,
                route('checkPayment', ['order_id' => $order->id]),
                $data->payment_method
            );

            $url = $payment->response->Data->PaymentURL ?? null;
            $order->payment_json = json_encode($payment->response);
            $order->save();

            return [
                'status' => true,
                'code' => 200,
                'message' => __('api.ok'),
                'item' => $order,
                'url' => $url ?: route('failPayment')
            ];
        });
    }

    public function checkPayment($data, $order_id)
    {
        if (!$data->has('paymentId') || empty($order_id)) {
            return ['redirect' => route('failPayment')];
        }

        return DB::transaction(function () use ($data, $order_id) {
            $check = $this->paymentGateway->validatePayment($data->paymentId);
            if ($check->status && isset($check->response->Data) && $check->response->Data->InvoiceStatus === "Paid") {
                $order = Order::findOrFail($order_id);
                $this->updateOrderPayment($order, $check, $data->paymentId);
                $this->updateStockAndCart($order);
                if(auth('web')->check()){
                    $this->updateOrderStatusFali(auth('web')->id());
                }

                updateFirebase('increment');

                if (isset($order)) {
                    $emailData = [
                        'to' => $order->email ?? auth('web')->user()->email,
                        'subject' => $this->settings->title .'|' . __('cp.invoice'),
                    ];
                    $message = view('website.invoice', ['order' =>$order])->render();
                    $this->notificationService->sendNotification($message, $emailData, 'email');
                }

                return ['redirect' => route('successPayment', ['order_id' => $order_id])];
            }
            return ['redirect' => route('failPayment')];
        });
    }

    private function getCartQuery()
    {
        $query = Cart::query();
        if (auth('web')->check()) {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())->orWhere('user_key', Session::get('cart.ids'));
            });
        } else {
            $query->where('user_key', Session::get('cart.ids'))->where('user_id', null);
        }
        return $query;
    }

    private function calculateTotals($cart, $request)
    {
        $total_cart = 0;
        $discount = 0;
        $delivery_charge = 0;
        $weight = 0;

        foreach ($cart as $one) {
            $productData = $this->getProductData($one);
            if ($productData['quantity'] < $one->quantity) {
                $message = __('website.noQuantity') . " (" . $productData['name'];
                if ($productData['color']) $message .= " - " . $productData['color'];
                if ($productData['size']) $message .= " - " . $productData['size'];
                $message .= ") " . __('website.remainingQuantity') . ": " . $productData['quantity'];
                return ['error' => ['status' => false, 'code' => 201, 'message' => $message]];
            }

            $price_val = $one->product->getRawOriginal('price_offer') ?: $one->product->getRawOriginal('price');
            $total_cart += $price_val * $one->quantity;
            $weight += $one->product->weight;
        }

        $delivery_charge = $this->calculateDeliveryCharge($request, $weight);
        if ($request->code_name) {
            $promo = $this->validatePromoCode($request->code_name, $this->getCountryId($request));
            if ($promo) {
                $discount = ($total_cart * $promo->discount_percentage) / 100;
                $total_cart = round($total_cart - $discount, 2);
            }
        }

        return [
            'total_cart' => $total_cart,
            'delivery_charge' => $delivery_charge,
            'discount' => $discount,
            'final_total' => $total_cart + $delivery_charge
        ];
    }

    private function getProductData($cartItem)
    {
        if ($cartItem->product_color_size_id) {
            $product = ProductColorSize::findOrFail($cartItem->product_color_size_id);
            return [
                'quantity' => $product->quantity,
                'name' => $product->product->name,
                'color' => $product->color->name ?? null,
                'size' => $product->size->name ?? null
            ];
        }

        $product = Product::findOrFail($cartItem->product_id);
        return [
            'quantity' => $product->remaining_quantity,
            'name' => $product->name,
            'color' => null,
            'size' => null
        ];
    }

    private function calculateDeliveryCharge($request, $weight)
    {
        if (auth('web')->check() && $request->has('address_id') && $request->address_id) {
            $address = UserAddress::where('user_id', auth('web')->id())->findOrFail($request->address_id);
            return $address->country_id == 1 ? $address->city->delivery_fees : $weight * $address->country->delivery_fees;
        }

        if ($request->country_id == 1 && $request->city_id) {
            $area = City::findOrFail($request->city_id);
            return $area->delivery_fees;
        } elseif ($request->country_id > 1) {
            $country = Country::findOrFail($request->country_id);
            return $weight * $country->delivery_fees;
        }

        return 0;
    }

    private function validatePromoCode($code, $countryId)
    {
        $promo = PromoCode::active()
            ->where('code', $code)
            ->where('number_remaining_uses', '>', 0)
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->first();

        if (!$promo) {
            $message = __('website.Invalid Promo Code');
            return ['error' => ['status' => false, 'code' => 201, 'message' => $message]];
        }

        if ($promo && $promo->all_countries != 1) {
            $allowedCountryIds = PromoCodeCountry::pluck('country_id')->toArray();
            if (!in_array($countryId, $allowedCountryIds)) {
                $message = __('website.Invalid Promo Code');
                return ['error' => ['status' => false, 'code' => 201, 'message' => $message]];
            }
        }

        return $promo;
    }

    private function getCountryId($request)
    {
        if (auth('web')->check() && $request->has('address_id') && $request->address_id) {
            $address = UserAddress::where('user_id', auth('web')->id())->findOrFail($request->address_id);
            return $address->country_id;
        }
        return $request->country_id;
    }

    private function createOrder($request, $totals, $cart)
    {
        $order = new Order();
        $order->total = $totals['final_total'];
        $order->sub_total = $totals['total_cart'];
        $order->delivery_fees = $totals['delivery_charge'];
        $order->discount = $totals['discount'];
        $order->discount_code = null;
        if ($request->code_name) {
            $promo = $this->validatePromoCode($request->code_name, $this->getCountryId($request));
            $order->discount_code = $promo->code ?? null;
        }
        $order->coupon_id = $promo->id ?? null;
        $order->user_key = Session::get('cart.ids');
        $order->status = 0;
        $order->payment_method = $request->payment_method;

        if (auth('web')->check()) {
            $order->user_id = auth('web')->id();
            $order->address_id = $request->address_id;
        } else {
            $order->name = $request->name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->country_id = $request->country_id;
            $order->city_id = $request->city_id;
            $order->address_line_one = $request->address_line_one;
            $order->address_line_two = $request->address_line_two;
            $order->postal_code = $request->postal_code;
            $order->extra_directions = $request->extra_directions;
        }

        $order->count_products = count($cart);
        $order->save();

        return $order;
    }

    private function createOrderProducts($order, $cart)
    {
        foreach ($cart as $one) {
            $priceOffer = $one->product->getRawOriginal('price_offer') ?: 0;
            $ProductOrder = new OrderProduct();
            $ProductOrder->order_id = $order->id;
            $ProductOrder->product_id = $one->product_id;
            $ProductOrder->product_color_size_id = $one->product_color_size_id ?? null;
            $ProductOrder->color_id = $one->color_id ?? null;
            $ProductOrder->size_id = $one->size_id ?? null;
            $ProductOrder->quantity = $one->quantity;
            $ProductOrder->price_offer = $priceOffer;
            $ProductOrder->price = $one->product->getRawOriginal('price');
            $ProductOrder->save();
        }
    }

    private function updateOrderPayment($order, $check, $paymentId)
    {
        $order->update([
            'payment_status' => 1,
            'payment_check_response' => json_encode($check->response),
            'payment_id' => $paymentId,
            'transaction_id' => $check->response->Data->InvoiceTransactions[0]->TransactionId,
            'InvoiceReference' => $check->response->Data->InvoiceReference,
        ]);

        if ($order->coupon_id) {
            $promo = PromoCode::active()
                ->where('id', $order->coupon_id)
                ->where('number_remaining_uses', '>', 0)
                ->whereDate('end_date', '>=', now())
                ->whereDate('start_date', '<=', now())
                ->first();
            if ($promo) {
                $promo->decrement('number_remaining_uses');
            }
        }
    }

    private function updateStockAndCart($order)
    {
        foreach ($order->products as $orderProduct) {
            if ($orderProduct->product_color_size_id) {
                $productColorSize = ProductColorSize::findOrFail($orderProduct->product_color_size_id);
                $productColorSize->decrement('quantity', $orderProduct->quantity);
            }
            $product = Product::findOrFail($orderProduct->product_id);
            $product->decrement('remaining_quantity', $orderProduct->quantity);
        }

        $this->getCartQuery()->forceDelete();
    }

    private function updateOrderStatusFali($user_id)
    {
       Order::where('user_id',$user_id)->where('payment_status' , 0)->update(['payment_status' => 2]);
    }

}
