<?php

namespace App\Services;

use App\Models\{Cart,
    Country,
    City,
    NotifyProduct,
    Product,
    ProductColorSize,
    PromoCode,
    PromoCodeCountry,
    Setting,
    UserAddress};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cache, Session};
use Illuminate\Support\Str;

class CartService
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::first();
    }

    /**
     * Apply user-related conditions to cart queries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyCartUserConditions($query)
    {
        if (Auth::guard('web')->check()) {
            $userId = Auth::id();
            $query->where('user_id', $userId);

            $userKey = Session::get('cart.ids');
            if ($userKey) {
                $query->orWhere(function ($q) use ($userKey) {
                    $q->where('user_key', $userKey)->whereNull('user_id');
                });
            }
        } else {
            $userKey = Session::get('cart.ids');
            $query->where('user_key', $userKey)
                ->whereNull('user_id');
        }

        return $query;
    }

    public function getCartItems()
    {
        $query = Cart::query();
        $query = $this->applyCartUserConditions($query);
        return $query->get();
    }

    public function getCartData()
    {
        $cart = $this->getCartItems();
        $total_cart = 0;

        foreach ($cart as $one) {
            $priceInCart = $one->product->price_offer > 0 ? $one->product->price_offer : $one->product->price;
            $total_cart += $priceInCart * $one->quantity;
        }

        return [
            'cart' => $cart,
            'total_cart' => round($total_cart, 3)
        ];
    }

    public function prepareCheckoutData($cart)
    {
        $data = ['countries' => Country::active()->get()];
        $total_cart = 0;

        foreach ($cart as $one) {
            $priceInCart = $one->product->getRawOriginal('price_offer') ?: $one->product->getRawOriginal('price');
            $total_cart += $priceInCart * $one->quantity;
        }

        $total_cart = $this->applyCurrencyConversion($total_cart);

        $data['total_cart'] = $total_cart;

        if (Auth::guard('web')->check()) {
            $data['addresses'] = UserAddress::where('user_id', Auth::id())
                ->orderByDesc('id')
                ->get();
        }

        return $data;
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $productColorSize = $request->product_color_size_id
            ? ProductColorSize::where('quantity', '>', 0)->findOrFail($request->product_color_size_id)
            : null;

        $oldProductCart = $this->checkExistingCartItem($request, $productColorSize);

        if ($oldProductCart) {
            return response()->json([
                'status' => false,
                'message' => __('website.existsOld')
            ]);
        }

        $cart = $this->createCartItem($product, $productColorSize, $request->quantity);

        return response()->json([
            'status' => true,
            'message' => __('website.ok')
        ]);
    }

    public function notifyProduct(Request $request)
    {
        $oldNotify = NotifyProduct::where([
            'product_id' => $request->product_id,
            'email' => Auth::guard('web')->user()->email,
            'user_id' => Auth::id()
        ])->first();

        if ($oldNotify) {
            return response()->json([
                'status' => false,
                'code' => 201,
                'message' => __('website.sendOld')
            ]);
        }

        $productColorSize = $request->product_color_size_id
            ? ProductColorSize::findOrFail($request->product_color_size_id)
            : null;

        NotifyProduct::create([
            'product_id' => $request->product_id,
            'email' => Auth::guard('web')->user()->email,
            'user_id' => Auth::id(),
            'color_id' => $productColorSize?->color_id,
            'size_id' => $productColorSize?->size_id
        ]);

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => __('api.ok')
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $query = Cart::query()
            ->where('product_id', $request->product_id);

        if ($request->product_color_size_id) {
            $query->where('product_color_size_id', $request->product_color_size_id);
        }

        $query = $this->applyCartUserConditions($query);

        $cart = $query->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => __('website.not_found')
            ]);
        }

        $cart->forceDelete();
        $carts = $this->getCartItems();
        $total_cart = 0;

        foreach ($carts as $item) {
            $priceInCart = $item->product->price_offer > 0 ? $item->product->price_offer : $item->product->price;
            $total_cart += $priceInCart * $item->quantity;
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => __('website.ok'),
            'count_products' => $carts->count(),
            'final_total' => number_format($total_cart, 3)
        ]);
    }

    public function updateQuantity(Request $request)
    {
        try {
            $cart = $this->getCartItemForUpdate($request);

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $maxQuantity = $this->getMaxQuantity($cart, $request);
            $newQuantity = min($request->quantity, $maxQuantity);

            $cart->update(['quantity' => $newQuantity]);
            $total_cart = 0;

            $carts = $this->getCartItems();
            foreach ($carts as $item) {
                $priceInCart = $item->product->price_offer > 0 ? $item->product->price_offer : $item->product->price;
                $total_cart += $priceInCart * $item->quantity;
            }

            return response()->json([
                'status' => true,
                'final_total' => number_format($total_cart, 3)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function applyPromoCode(Request $request)
    {
        $cartData = $this->calculateCartTotals($request);

        if ($cartData['product_missing']) {
            return response()->json([
                'status' => true,
                'message' => __('website.not_exists'),
                'code' => 600
            ]);
        }

        $promo = $this->validatePromoCode($request, $cartData['country_id']);

        $response = [
            'status' => isset($promo),
            'code' => isset($promo) ? 200 : 201,
            'message' => isset($promo) ? __('api.ok') : __('website.wrongPromo'),
            'total_cart' => $cartData['total_cart'],
            'delivery_charge' => $cartData['delivery_charge'],
            'final_total' => $cartData['final_total'],
            'discount' => $cartData['discount']
        ];

        return response()->json($response);
    }

    public function calculateDeliveryCost(Request $request)
    {
        $cartData = $this->calculateCartTotals($request);

        if ($cartData['product_missing']) {
            return response()->json([
                'status' => true,
                'message' => __('website.not_exists'),
                'code' => 600
            ]);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => __('api.ok'),
            'total_cart' => $cartData['total_cart'],
            'delivery_charge' => $cartData['delivery_charge'],
            'final_total' => $cartData['final_total'],
            'discount' => $cartData['discount'],
            'country_id' => $cartData['country_id'] ?? null
        ]);
    }

    protected function applyCurrencyConversion($amount)
    {
        $currency = Cache::has('currency') ? Cache::get('currency') : $this->settings;
        $selectedCurrency = Session::get('currency');

        if ($selectedCurrency) {
            $rates = [
                'SAR' => (float) $currency->SAR,
                'BHD' => (float) $currency->BHD,
                'OMR' => (float) $currency->OMR,
                'QAR' => (float) $currency->QAR,
                'AED' => (float) $currency->AED
            ];

            return isset($rates[$selectedCurrency]) ? $amount * $rates[$selectedCurrency] : $amount;
        }

        return $amount;
    }

    protected function checkExistingCartItem(Request $request, $productColorSize)
    {
        $query = Cart::query()
            ->where('product_id', $request->product_id);

        if ($productColorSize) {
            $query->where('product_color_size_id', $request->product_color_size_id);
        }

        $query = $this->applyCartUserConditions($query);

        return $query->first();
    }

    protected function createCartItem($product, $productColorSize, $quantity)
    {
        $cart = new Cart();

        if (Auth::guard('web')->check()) {
            $cart->user_id = Auth::id();
        } else {
            $user_key = Session::get('cart.ids') ?: Str::uuid()->toString() . $product->id;
            $cart->user_key = $user_key;

            if (!Session::has('cart.ids')) {
                Session::put('cart', ['ids' => $user_key]);
            }
        }

        $cart->product_id = $product->id;

        if ($productColorSize) {
            $cart->product_color_size_id = $productColorSize->id;
            $cart->color_id = $productColorSize->color_id;
            $cart->size_id = $productColorSize->size_id;
        }

        $cart->quantity = $quantity ?: 1;
        $cart->save();

        return $cart;
    }

    protected function getCartItemForUpdate(Request $request)
    {
        $query = Cart::query()
            ->where('id', $request->cart_id)
            ->where('product_id', $request->product_id);

        $query = $this->applyCartUserConditions($query);

        return $query->first();
    }

    protected function getMaxQuantity($cart, Request $request)
    {
        if ($request->size_id || $request->color_id) {
            return $cart->product->productColorSizes()
                ->when($request->size_id, fn($q) => $q->where('size_id', $request->size_id))
                ->when($request->color_id, fn($q) => $q->where('color_id', $request->color_id))
                ->first()
                ?->quantity ?? 0;
        }

        return $cart->product->remaining_quantity;
    }

    protected function validatePromoCode(Request $request, $countryId)
    {
        $promo = PromoCode::active()
            ->where('code', $request->code_name)
            ->where('number_remaining_uses', '>', 0)
            ->whereDate('end_date', '>=', now())
            ->whereDate('start_date', '<=', now())
            ->first();

        if ($promo && $promo->all_countries != 1 && $countryId) {
            $allowedCountryIds = PromoCodeCountry::where('promo_code_id', $promo->id)
                ->pluck('country_id')
                ->toArray();
            if (!in_array($countryId, $allowedCountryIds)) {
                return null;
            }
        }

        return $promo;
    }

    protected function calculateCartTotals(Request $request)
    {
        $cart = $this->getCartItems();
        $total_cart = 0;
        $weight = 0;
        $discount = 0;
        $delivery_charge = 0;
        $product_missing = false;

        foreach ($cart as $item) {
            $product = $item->product_color_size_id
                ? ProductColorSize::find($item->product_color_size_id)
                : Product::find($item->product_id);

            if (!$product) {
                $product_missing = true;
                break;
            }

            $price = $item->product->getRawOriginal('price_offer') ?: $item->product->getRawOriginal('price');
            $total_cart += $price * $item->quantity;
            $weight += $item->product->weight;
        }

        $countryId = $this->getCountryId($request);

        if ($request->code_name) {
            $promo = $this->validatePromoCode($request, $countryId);
            if ($promo) {
                $discount = ($total_cart * $promo->discount_percentage) / 100;
            }
        }

        $delivery_charge = $this->calculateDeliveryCharge($request, $weight, $countryId);

        $final_total = $total_cart - $discount + $delivery_charge;

        $amounts = $this->applyCurrencyConversionToArray([
            'total_cart' => number_format($total_cart, 3),
            'delivery_charge' => number_format($delivery_charge, 3),
            'final_total' => number_format($final_total, 3),
            'discount' => number_format($discount, 3)
        ]);

        return array_merge($amounts, [
            'country_id' => $countryId,
            'product_missing' => $product_missing
        ]);
    }

    protected function getCountryId(Request $request)
    {
        if (Auth::guard('web')->check() && $request->address_id) {
            return UserAddress::where('user_id', Auth::id())
                ->findOrFail($request->address_id)
                ->country_id;
        }

        return $request->country_id;
    }

    protected function calculateDeliveryCharge(Request $request, $weight, $countryId)
    {
        if (Auth::guard('web')->check() && $request->address_id) {
            $address = UserAddress::where('user_id', Auth::id())->findOrFail($request->address_id);

            return $address->country_id == 1
                ? $address->city->delivery_fees
                : $weight * $address->country->delivery_fees;
        }

        if ($request->country_id) {
            if ($request->country_id == 1 && $request->city_id) {
                return City::findOrFail($request->city_id)->delivery_fees;
            }

            return $weight * Country::active()->findOrFail($request->country_id)->delivery_fees;
        }

        return 0;
    }

    protected function applyCurrencyConversionToArray(array $amounts)
    {
        $currency = Cache::has('currency') ? Cache::get('currency') : $this->settings;
        $selectedCurrency = Session::get('currency');

        if (!$selectedCurrency) {
            return $amounts;
        }

        $rate = match ($selectedCurrency) {
            'SAR' => $currency->SAR,
            'BHD' => $currency->BHD,
            'OMR' => $currency->OMR,
            'QAR' => $currency->QAR,
            'AED' => $currency->AED,
            default => 1
        };

        return array_map(fn($amount) => number_format((float)$amount * $rate, 3), $amounts);
    }
}
