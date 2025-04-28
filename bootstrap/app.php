<?php

use App\Http\Middleware\{AdminMiddleware, SubAdminMiddleware, CustomMaintenanceMode, UserMiddleware};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \Mcamara\LaravelLocalization\Middleware\{LaravelLocalizationRoutes,
    LaravelLocalizationRedirectFilter,
    LocaleSessionRedirect,
    LocaleCookieRedirect,
    LaravelLocalizationViewPath
};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(CustomMaintenanceMode::class);

        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'subadmin' => SubAdminMiddleware::class,
            'user' => UserMiddleware::class,
            'localize' => LaravelLocalizationRoutes::class,
            'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => LocaleSessionRedirect::class,
            'localeCookieRedirect' => LocaleCookieRedirect::class,
            'localeViewPath' => LaravelLocalizationViewPath::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
