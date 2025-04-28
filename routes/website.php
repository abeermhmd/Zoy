<?php

use App\Http\Controllers\Auth\{LoginController, ForgotPasswordController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\{OrderController,
    HomeController,
    UserController,
    ProductController,
    FavoriteController,
    CartController
};

////////////////////////LoginController//////////////////////
Route::controller(LoginController::class)->group(function () {
    //Google
    Route::post('login/{provider}', 'redirectToProvider')->name('login.social');
    Route::get('login/{provider}/callback', 'handleProviderCallback')->name('login.social.callback');

    //  Apple
    Route::post('login/apple/callback', 'handleAppleCallback')->name('login.apple.callback');

    //General
    Route::post('login', 'login')->name('login');
    Route::post('loginPopUp', 'login')->name('loginPopUp');
    Route::get('logout', 'logout')->name('logout');

});

Route::get('login', function () {
    return redirect()->route('signIn');
})->middleware('guest:web')->name('login');


Route::group(['middleware' => ['user']], function () {
    ////////////////////////UserController With Auth//////////////////////
    Route::controller(UserController::class)->group(function () {
        Route::get('myAccount', 'myAccount')->name('myAccount');
        Route::post('updateProfile', 'updateProfile')->name('updateProfile');
        Route::get('orders', 'myOrders')->name('orders');
        Route::get('orderDetails/{order_id}', 'orderDetails')->name('orderDetails');
        Route::get('addresses', 'myAddresses')->name('myAddresses');
        Route::get('savedCards', 'myCards')->name('myCards');
        Route::get('wishlist', 'myFavorite')->name('myFavorite');
        Route::get('changePassword', 'changePassword')->name('changePassword');
        Route::post('changePasswordPost', 'changePasswordPost')->name('changePasswordPost');
        Route::post('addAddress', 'addAddress')->name('addAddress');
        Route::get('deleteAddress/{id}', 'deleteAddress')->name('deleteAddress');
        Route::get('addressDetails/{id}', 'addressDetails')->name('addressDetails');
        Route::post('updateAddress/{id}', 'updateAddress')->name('updateAddress');

    });
});
Route::group(['middleware' => ['guest:web']], function () {
    ////////////////////////UserController  Without Auth//////////////////////
    Route::controller(UserController::class)->group(function () {
        Route::get('signIn', 'signIn')->name('signIn');
        Route::get('signUpApple', 'signUpApple')->name('signUpApple');
        Route::get('signUpGoogle', 'signUpGoogle')->name('signUpGoogle');
        Route::get('resetPassword', 'resetPassword')->name('resetPassword');
        Route::post('register', 'register')->name('register');
        Route::get('signUp', 'signUp')->name('signUp');

    });


    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forgotPassword', 'forgotPassword')->name('forgotPassword');
        Route::post('forgot-password', 'sendResetLink')->name('password.email');
        Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('reset-password', 'resetPassword')->name('password.update');
    });
});
////////////////////////HomeController//////////////////////
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('subscribe', 'subscribe')->name('subscribe');
    Route::get('page/{slug}', 'pages')->name('pages');
    Route::get('faqs', 'faqs')->name('faqs');
    Route::get('contactUs', 'contactUs')->name('contactUs');
    Route::post('contactUsPost', 'contactUsPost')->name('contactUsPost');
    Route::get('/changeCurrency/{Currency}', 'changeCurrency')->name('changeCurrency');
    Route::post('get-cities', 'getCities')->name('get.cities');

});

////////////////////////ProductController//////////////////////
Route::controller(ProductController::class)->group(function () {
    Route::get('/products/{category_id}', 'products')->name('products');
    Route::get('/productDetails/{product_id}', 'productDetails')->name('productDetails');
    Route::get('/search', 'search')->name('search');
});

////////////////////////CartController//////////////////////
Route::controller(CartController::class)->group(function () {
    Route::get('cart', 'index')->name('cart');
    Route::get('checkOutPage', 'checkOutPage')->name('checkOutPage');
    Route::post('addProductToCart', 'addProductToCart')->name('addProductToCart');
    Route::post('deleteProductCart', 'deleteProductCart')->name('deleteProductCart');
    Route::post('changeQuantity', 'changeQuantity')->name('changeQuantity');
    Route::post('notifyMe', 'notifyMe')->name('notifyMe')->middleware('user');
    Route::post('checkPromo', 'checkPromo')->name('checkPromo');
    Route::get('getDeliveryCost', 'getDeliveryCost')->name('getDeliveryCost');

});


/////////////////////////FavoriteController/////////////////////////////
Route::controller(FavoriteController::class)->group(function () {
    Route::post('removeFavorite', 'removeFavorite')->name('removeFavorite');
    Route::post('addToFavorite', 'addToFavorite')->name('addToFavorite');
});

/////////////////////////OrderController/////////////////////////////
Route::controller(OrderController::class)->group(function () {
    Route::post('checkOut', 'checkOut')->name('checkOut');
    Route::get('checkPayment/{order_id}', 'checkPayment')->name('checkPayment');
    Route::get('failPayment', 'failPayment')->name('failPayment');
    Route::get('successPayment/{order_id}', 'successPayment')->name('successPayment');
});




