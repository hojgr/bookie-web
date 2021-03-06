<?php namespace BookieGG\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'BookieGG\Http\Middleware\VerifyCsrfToken',

    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'beta.active_only' => 'BookieGG\Http\Middleware\RedirectNonActivatedAccounts',
        'beta.not_active_only' => 'BookieGG\Http\Middleware\RedirectActivatedAccounts',
        'admin.protect' => 'BookieGG\Http\Middleware\ProtectAdmin'
    ];

}
