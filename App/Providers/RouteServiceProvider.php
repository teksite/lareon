<?php

namespace Lareon\CMS\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Teksite\Lareon\Facade\Lareon;

class RouteServiceProvider  extends ServiceProvider
{

    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the module.
     */

    public function map(): void
    {
        $routes = config('lareon.cms.routes', []);
        foreach ($routes as $route) {
            if ($route['path']) {
                $path = cms_path('routes' . DIRECTORY_SEPARATOR . $route['path']);
                $middleware = $route['middleware'] ?? [];
                $prefix = $route['prefix'] ?? '';
                $name = $route['name'] ?? '';
                if (file_exists($path)) {
                    Route::middleware($middleware)->prefix($prefix)->name($name)->group($path);
                }
            }
        }

    }
}
