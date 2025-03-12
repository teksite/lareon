<?php

namespace Teksite\Lareon;

use Illuminate\Support\ServiceProvider;
use Teksite\Lareon\Console\App\MakerAdminUser;
use Teksite\Lareon\Console\App\RefreshAppCommand;
use Teksite\Lareon\Console\Install\InstallerCommand;
use Teksite\Lareon\Console\Make\CastMakeCommand;
use Teksite\Lareon\Console\Make\ModuleMakeCommand;
use Teksite\Lareon\Console\Migrate\SeedCommand;
use Teksite\Lareon\Services\Builder\JsonResponse;
use Teksite\Lareon\Services\Builder\WebResponse;
use Teksite\Lareon\Services\LareonServices;
use Teksite\Lareon\Console\Make\ChannelMakeCommand;
use Teksite\Lareon\Console\Make\ClassMakeCommand;
use Teksite\Lareon\Console\Make\CommandMakeCommand;
use Teksite\Lareon\Console\Make\ComponentMakeCommand;
use Teksite\Lareon\Console\Make\ControllerMakeCommand;
use Teksite\Lareon\Console\Make\EnumMakeCommand;
use Teksite\Lareon\Console\Make\EventMakeCommand;
use Teksite\Lareon\Console\Make\ExceptionMakeCommand;
use Teksite\Lareon\Console\Make\FactoryMakeCommand;
use Teksite\Lareon\Console\Make\InterfaceMakeCommand;
use Teksite\Lareon\Console\Make\JobMakeCommand;
use Teksite\Lareon\Console\Make\JobMiddlewareMakeCommand;
use Teksite\Lareon\Console\Make\ListenerMakeCommand;
use Teksite\Lareon\Console\Make\LogicMakeCommand;
use Teksite\Lareon\Console\Make\MailMakeCommand;
use Teksite\Lareon\Console\Make\MiddlewareMakeCommand;
use Teksite\Lareon\Console\Make\MigrationMakeCommand;
use Teksite\Lareon\Console\Make\ModelMakeCommand;
use Teksite\Lareon\Console\Make\NotificationMakeCommand;
use Teksite\Lareon\Console\Make\ObserverMakeCommand;
use Teksite\Lareon\Console\Make\PolicyMakeCommand;
use Teksite\Lareon\Console\Make\ProviderMakeCommand;
use Teksite\Lareon\Console\Make\RequestMakeCommand;
use Teksite\Lareon\Console\Make\ResourceMakeCommand;
use Teksite\Lareon\Console\Make\RuleMakeCommand;
use Teksite\Lareon\Console\Make\ScopeMakeCommand;
use Teksite\Lareon\Console\Make\SeederMakeCommand;
use Teksite\Lareon\Console\Make\TestMakeCommand;
use Teksite\Lareon\Console\Make\TraitMakeCommand;
use Teksite\Lareon\Console\Make\ViewMakeCommand;

class LareonPackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->registerConfig();
        $this->registerFacades();
        $this->registerProviders();
        $this->registerStubPath();
    }

    public function boot(): void
    {
        $this->bootCommands();
        $this->publish();
    }

    public function registerConfig(): void
    {
        $configPath = config_path('cms-setting.php');
        $this->mergeConfigFrom(
            file_exists($configPath) ? $configPath : __DIR__ . '/config/cms-setting.php', 'cms-setting');
    }

    public function registerFacades()
    {
        $this->app->singleton('Lareon', function () {
            return new LareonServices();
        });
        $this->app->singleton('WebResponse', function () {
            return new WebResponse();
        });
        $this->app->singleton('JsonResponse', function () {
            return new JsonResponse();
        });
    }

    public function registerProviders(): void
    {
        if (class_exists(\Lareon\CMS\App\Providers\CmsServiceProvider::class)) {
            $this->app->register(\Lareon\CMS\App\Providers\CmsServiceProvider::class);
        }
    }

    public function registerStubPath(): void
    {
        $this->app->bind('cms.stubs', function () {
            return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
        });
    }

    public function bootCommands(): void
    {
        $this->commands([
            InstallerCommand::class,

            CastMakeCommand::class,
            ChannelMakeCommand::class,
            ClassMakeCommand::class,
            CommandMakeCommand::class,
            ComponentMakeCommand::class,
            ControllerMakeCommand::class,
            EnumMakeCommand::class,
            EventMakeCommand::class,
            ExceptionMakeCommand::class,
            FactoryMakeCommand::class,
            InterfaceMakeCommand::class,
            JobMakeCommand::class,
            JobMiddlewareMakeCommand::class,
            ListenerMakeCommand::class,
            LogicMakeCommand::class,
            MailMakeCommand::class,
            MiddlewareMakeCommand::class,
            MigrationMakeCommand::class,
            ModelMakeCommand::class,
            NotificationMakeCommand::class,
            ObserverMakeCommand::class,
            PolicyMakeCommand::class,
            ProviderMakeCommand::class,
            RequestMakeCommand::class,
            ResourceMakeCommand::class,
            RuleMakeCommand::class,
            ScopeMakeCommand::class,
            SeederMakeCommand::class,
            TestMakeCommand::class,
            TraitMakeCommand::class,
            ViewMakeCommand::class,

            SeedCommand::class,
            ModuleMakeCommand::class,

            RefreshAppCommand::class,
            MakerAdminUser::class,

        ]);
    }


    /**
     * @return void
     */
    public function publish(): void
    {
        $this->publishes([
            __DIR__ . '/config/cms-setting.php' => config_path('cms-setting.php')], 'cms-setting');
    }
}
