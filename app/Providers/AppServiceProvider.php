<?php

namespace App\Providers;

use App\Contracts\BannerContract;
use App\Services\BannerService;
use App\Models\{Category, Language, Setting};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Services\Payment\{MyFatoorahPayment, PaymentGatewayInterface};
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, MyFatoorahPayment::class);
        $this->app->bind(BannerContract::class, BannerService::class);
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
