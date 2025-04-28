<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAdmin\LoginController;
use App\Http\Controllers\AdminCpanel\{CategoryController ,SubCategoryController, HomeController , SettingController ,
        AdminController ,PermissionController ,UserController , PageController , ContactController,ShippingController,
        BannerController , FAQController ,PromoCodeController , ColorController , SizeController , ProductController ,
        SubscriberController , NewsletterController , ExportExcelController , OrderController , ReportController
        ,EmailTextController , ManualEmailController , UploadImageController
};


                        //////Start Auth Routes //////
    Route::group(['middleware' => ['guest:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/login', [LoginController::class , 'create'])->name('login.form');
        Route::post('/login', [LoginController::class , 'store'])->name('login');
    });
    Route::get('admin/logout', [LoginController::class , 'logout'])->name('admin.logout');
                        //////End Auth Routes //////


    Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admins.',], function () {
        Route::get('/', function () { return redirect('/admin/home'); });
        Route::post('/changeStatus/{model}', [HomeController::class , 'changeStatus']);


        Route::get('home', [HomeController::class , 'index'])->name('admin.home');

        Route::post('/storeOnlyImage', [UploadImageController::class, 'storeOnlyImage'])->name('image.upload');

                    ///////this routes for add admins//////
        Route::resource('admins', AdminController::class)->except('show');

                        ///////this routes for auth admin profile//////
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admins/{id}/edit_password', 'edit_password')->name('admins.edit_password');
            Route::post('/admins/{id}/edit_password', 'update_password')->name('admins.edit_password');
            Route::get('/editMyProfile', 'editMyProfile')->name('admins.editMyProfile');
            Route::post('/updateProfile', 'updateProfile')->name('admins.updateProfile');
            Route::get('/changeMyPassword', 'changeMyPassword')->name('admins.changeMyPassword');
            Route::post('/updateMyPassword', 'updateMyPassword')->name('admins.updateMyPassword');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('users.all');
                Route::get('create', 'create')->name('users.create');
                Route::post('/', 'store')->name('users.store');
                Route::get('{id}/show', 'show')->name('users.show');
                Route::get('{id}/edit', 'edit')->name('users.edit');
                Route::post('{id}', 'update')->name('users.update');
                Route::get('{id}/edit_password', 'edit_password')->name('users.edit_password');
                Route::post('{id}/edit_password', 'update_password')->name('users.update_password');
                Route::get('/{id}/addresses', 'addresses')->name('users.addresses');
                Route::get('/{id}/orders', 'orders')->name('users.orders');
                Route::get('/{id}/showOrder/{order}', 'showOrder')->name('users.showOrder');
            });
        });


        Route::resource('categories', CategoryController::class);


         Route::controller(ReportController::class)->group(function () {
             Route::get('reports', 'index')->name('reports');
             Route::get('salesByCountry', 'salesByCountry')->name('salesByCountry');
             Route::get('usersOrdersReports', 'usersOrdersReports')->name('usersOrdersReports');
         });

        Route::resource('subCategories', SubCategoryController::class);

        Route::resource('emailTexts', EmailTextController::class);

        Route::resource('manual_emails', ManualEmailController::class);

        Route::resource('banners', BannerController::class);
        Route::controller(BannerController::class)->group(function () {
            Route::get('bannerAd', 'bannerAd')->name('bannerAd');
            Route::post('bannerAdUpdate', 'bannerAdUpdate')->name('bannerAdUpdate');
            Route::get('adPopUp', 'adPopUp')->name('adPopUp');
            Route::post('adPopUpUpdate', 'adPopUpUpdate')->name('adPopUpUpdate');
        });

        Route::resource('contact', ContactController::class);
        Route::get('viewMessage/{id}',[ContactController::class , 'viewMessage'])->name('viewMessage');


        Route::resource('faqs', FAQController::class);

        Route::resource('colors', ColorController::class);

        Route::resource('sizes', SizeController::class);

        Route::resource('products', controller: ProductController::class);
        Route::controller(ProductController::class)->group(function () {
            Route::get('productsQuantites/{id}', 'quantites')->name('products.quantites');
            Route::post('productsQuantites/{id}', 'updateQuantites')->name('products.update.quantites');
        });


        Route::controller(ShippingController::class)->group(function () {
            Route::get('shippingContent', 'content')->name('shipping.content');
            Route::post('shippingContent', 'updateContent')->name('update.shipping.content');

            Route::get('shippingPrices', 'shippingPrices')->name('shipping.prices');
            Route::post('shippingPrices', 'updateShippingPrices')->name('update.shipping.prices');
        });

        Route::resource('promoCodes', PromoCodeController::class);

        Route::resource('subscribers', SubscriberController::class);

        Route::resource('newsletters', NewsletterController::class);

        Route::resource('orders', OrderController::class);

        Route::resource('pages', PageController::class)->except('show');

        Route::resource('permissions', PermissionController::class)->except('show');

        Route::resource('settings', SettingController::class)->only(['index', 'update']);

        Route::controller(SettingController::class)->group(function () {
            Route::get('system_maintenance', 'system_maintenance')->name('system.maintenance');
            Route::post('system_maintenance', 'update_system_maintenance')->name('update.system.maintenance');
            Route::get('system_seo', 'system_seo')->name('system.system_seo');
            Route::post('update_system_seo', 'update_system_seo')->name('system.update_system_seo');
        });

        //////////////////////////// Export Excel ////////////////////////////
        Route::controller(ExportExcelController::class)->group(function () {
            Route::get('exportProducts', 'exportProducts');
            Route::get('exportUsers', 'exportUsers');
            Route::get('exportSubscribers', 'exportSubscribers');
            Route::get('exportOrders', 'exportOrders');
            Route::get('exportReports', 'exportReports');
            Route::get('exportUsersOrdersReports', 'exportUsersOrdersReports');
        });
    });
