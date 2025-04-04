<?php

namespace Lareon\CMS\App\Providers\Modules;

use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Teksite\Module\Facade\Module;

class ModulesManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerModules();
        $this->registerConfigs();
        $this->registerViews();
    }

    public function boot(): void
    {
         $this->bootTranslations();
         $this->loadModuleMigrations();
         $this->loadModuleSeeders();
    }

    /**
     * Registers all modules specified in the config.
     */
    private function registerModules(): void
    {
        $modules = get_module_bootstrap();

        foreach ($this->lareonModules() as $name => $data) {
            $providerClass = $data['provider'];
            if (class_exists($providerClass)) $this->app->register($providerClass);

        }
    }

    /**
     * Publishes and merges the configuration files for all modules.
     */
    private function registerConfigs(): void
    {
        $configsFiles = config('lareon.modules.configs', []);

        foreach ($this->lareonModules() as $module => $data) {
            foreach ($configsFiles as $config) {
                $this->publishAndMergeConfig($module, $config);
            }
        }
    }
    private function publishAndMergeConfig(string $module, string $config): void
    {
        $lowerModuleName = strtolower($module);
        $suggestedConfigPath = module_path($module, "config/$config");
        $configName = str_replace('.php', '', $config);
        $configGroup=$configName;

        if (file_exists($suggestedConfigPath)) {
            if($configName==='config'){
                $configGroup='modules';
            }
            $this->publishes([$suggestedConfigPath => config_path("$lowerModuleName.php")], $configGroup);
            $this->mergeConfigFrom($suggestedConfigPath, "$configGroup.$lowerModuleName");
        }
    }

    /**
     * Registers translations for modules.
     */
    private function bootTranslations(): void
    {

        foreach ($this->lareonModules() as $module => $data) {
                $this->processTranslations($module);
        }
    }

    private function processTranslations(string $module): void
    {
        $lowerModuleName = strtolower($module);
        $langPath = module_path($module, config('lareon.lang_path', 'lang'));
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $lowerModuleName);
            $this->loadJsonTranslationsFrom($langPath);
        }
    }

    /**
     * Registers views for modules.
     */
    private function registerViews(): void
    {
        foreach ($this->lareonModules() as $module => $data) {
                $this->processViews($module , $data);
        }

    }

    private function processViews(string $module ,array $data): void
    {
        $lowerModuleName = strtolower($module);
        $viewPath = resource_path('views/modules/' . $lowerModuleName);
        $sourcePath = module_path($module, 'resources/views');

        // Publish and load views
        $this->publishes([$sourcePath => $viewPath], ['views', $lowerModuleName . '-module-views']);
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths($lowerModuleName), [$sourcePath]), $lowerModuleName);

        // Register Blade components
        $this->registerBladeComponents($module, $lowerModuleName);
    }

    private function registerBladeComponents(string $module, string $lowerModuleName): void
    {
        $componentNamespace = module_namespace($module,'App/View');
        Blade::componentNamespace($componentNamespace, $lowerModuleName);
    }

    private function getPublishableViewPaths(string $lowerModuleName): array
    {
        return array_filter(config('view.paths'), fn($path) => is_dir($path . '/modules/' . $lowerModuleName));
    }

    /**
     * Loads module migrations.
     */
    private function loadModuleMigrations(): void
    {
        foreach ($this->lareonModules() as $module => $provider) {
                $this->loadMigrationsForModule($module);
        }
    }

    private function loadMigrationsForModule(string $module): void
    {
        $migrationPath = Module::modulePath($module, 'Database/Migrations');

        if (is_dir($migrationPath)) $this->loadMigrationsFrom($migrationPath);

    }

    /**
     * Listens for migration events to run seeders.
     */
    private function loadModuleSeeders(): void
    {
        Event::listen(MigrationsEnded::class, fn() => $this->runModuleSeeders());
    }

    private function runModuleSeeders(): void
    {
        $commands = $_SERVER['argv'] ?? [];
        if (in_array('db:seed', $commands) || in_array('--seed', $commands)) {
            foreach ($this->lareonModules() as $module => $provider) {
                $this->runSeederForModule($module);
            }
        }
    }

    private function runSeederForModule(string $module): void
    {
        $fullClassName = "Lareon\\Modules\\{$module}\\Database\\Seeders\\{$module}DatabaseSeeder";
        $mainSeederPath = Module::modulePath($module, "Database/Seeders/{$module}DatabaseSeeder.php");

        if (file_exists($mainSeederPath) && class_exists($fullClassName)) {
            Artisan::call('db:seed', ['--class' => $fullClassName]);
        }
    }


    private function lareonModules(bool $active = true): array
    {
      return lareonModules($active);
    }
}
