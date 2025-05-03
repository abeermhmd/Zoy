<?php

namespace App\Providers;

use App\Contracts\{AdminContract, BannerContract, CategoryContract, SubCategoryContract};
use App\Services\{AdminService, BannerService, CategoryService, SubCategoryService};
use App\Models\{Category, Language, Setting};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Services\Payment\{MyFatoorahPayment, PaymentGatewayInterface};
use Illuminate\Support\Facades\Schema;

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
