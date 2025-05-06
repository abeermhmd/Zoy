<?php

namespace App\Providers;

use App\Contracts\{AdminContract,
    BannerContract,
    CategoryContract,
    ColorContract,
    ProductContract,
    SizeContract,
    SubCategoryContract};
use App\Services\{AdminService,
    BannerService,
    CategoryService,
    ColorService,
    ProductService,
    SizeService,
    SubCategoryService};
use App\Models\{Category, Language, Setting};
use Illuminate\Support\ServiceProvider;
use App\Services\Payment\{MyFatoorahPayment, PaymentGatewayInterface};
use Illuminate\Support\Facades\{Schema, Cache};

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindServices([
            PaymentGatewayInterface::class => MyFatoorahPayment::class,
            AdminContract::class => AdminService::class,
            BannerContract::class => BannerService::class,
            CategoryContract::class => CategoryService::class,
            SubCategoryContract::class => SubCategoryService::class,
            ColorContract::class => ColorService::class,
            SizeContract::class => SizeService::class,
            ProductContract::class => ProductService::class,
        ]);
    }

    private function bindServices(array $bindings): void
    {
        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        $setting = $this->loadSettings();
        $this->updateCurrencyCache($setting);
        $this->shareViewData($setting);
    }

    private function loadSettings(): ?object
    {
        if (Schema::hasTable('settings')) {
            return Setting::query()->first();
        }
        return null;
    }

    private function updateCurrencyCache(?object $setting): void
    {
        if (Schema::hasTable('cache')) {
            Cache::forget('currency');
            Cache::forever('currency', $setting);
        }
    }
    private function shareViewData(?object $setting): void
    {
        view()->composer('*', function ($view) use ($setting) {
            $view->with([
                'setting' => $setting,
                'locales' => Language::get(),
                'categoriesMenu' => Category::active()->where('parent_id', null)->get(),
            ]);
        });
    }
}
