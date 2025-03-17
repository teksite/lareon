<?php

namespace Lareon\CMS\App\Providers\Modules;

use Illuminate\Support\Facades\Route;
use Teksite\Module\Facade\Module;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RoutesManagerServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        $routes = config('lareon.modules.routes', []);
        foreach (lareonModules() as $module => $data) {
            foreach ($routes as $route) {
                $routePath = Module::modulePath($module, 'routes' . DIRECTORY_SEPARATOR . $route['path']);
                if (file_exists($routePath)) {
                    Route::prefix($route['prefix'] ?? '')
                        ->name($route['name'] ?? '')
                        ->middleware($route['middleware'] ?? [])
                        ->group($routePath);
                }
            }
        }
    }
}
