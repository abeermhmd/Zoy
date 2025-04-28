<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $data = $this->cartService->getCartData();
        return view('website.cart', [
            'cart' => $data['cart'],
            'total_cart' => $data['total_cart']
        ]);
    }

    public function checkOutPage()
    {
        $cart = $this->cartService->getCartItems();
        if ($cart->isEmpty()) {
            return redirect()->route('cart');
        }

        $data = $this->cartService->prepareCheckoutData($cart);
        $view = auth('web')->check() ? 'website.userCheckout' : 'website.guestCheckout';

        return view($view, compact('cart', 'data'));
    }

    public function addProductToCart(CartRequest $request)
    {
        return $this->cartService->addToCart($request);
    }

    public function notifyMe(CartRequest $request)
    {
        return $this->cartService->notifyProduct($request);
    }

    public function deleteProductCart(CartRequest $request)
    {
        return $this->cartService->removeFromCart($request);
    }

    public function changeQuantity(Request $request)
    {
        return $this->cartService->updateQuantity($request);
    }

    public function checkPromo(CartRequest $request)
    {
        return $this->cartService->applyPromoCode($request);
    }

    public function getDeliveryCost(Request $request)
    {
        return $this->cartService->calculateDeliveryCost($request);
    }
}
