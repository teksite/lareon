<?php

namespace Teksite\Lareon\Console\Install;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Lareon\Traits\GeneratorCommandTrait;

class InstallerCommand extends Command
{
    use GeneratorCommandTrait;

    protected $signature = 'lareon:install
      ';

    protected $description = 'install lareon';

    protected $type = 'Install';

    public function handle()
    {

        $this->createDirectories();
        $this->createFiles();
        $this->dumpingComposer();

        $this->output->getFormatter()->setStyle('success', new OutputFormatterStyle('white', 'blue', ['bold']));
        $this->newLine();

        $this->info("<success>SUCCESS</success> Lareon cms is installed successfully.");
    }

    private function getCmsPath()
    {
        return Lareon::cmsPath();
    }


    private function createDirectories(): void
    {
        $directories = [
            '',
            'App/Http/Controllers',
            'App/Models',
            'App/Providers',
            'config',
            'Database/Factories',
            'Database/Migrations',
            'Database/Seeders',
            'lang',
            'resources/views',
            'resources/js',
            'resources/css',
            'routes',
            'Tests',
            'Tests/Feature',
            'Tests/Unit',
        ];
        $path = Lareon::cmsPath(absolute: false);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                File::makeDirectory("{$path}/{$directory}", 0755, true);
                $this->line("Directory: {$path}/{$directory} is generated");
            }
        }
    }

    private function createFiles(): void
    {
        $namespace = config('lareon.namespace');

        $path = Lareon::cmsPath(absolute: false);

        /* Register Composer file  */
        $this->generateFile(
            'basic/composer.stub',
            [
                '{{ namespace }}' => str_replace("\\", '\\\\', $namespace),
            ],
            "{$path}/composer.json"
        );

        /* Register ServiceProvider file  */
        $this->generateFile(
            'basic/provider-service.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "LareonServiceProvider",
            ],
            "{$path}/App/Providers/LareonServiceProvider.php"
        );
        /* Register ServiceProvider of modules  */
        $this->generateFile(
            'basic/provider-module-manager.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers\\Modules",
                '{{ class }}' => "ModulesManagerServiceProvider",
            ],
            "{$path}/App/Providers/Modules/ModulesManagerServiceProvider.php"
        );

        /* Register ServiceProvider of routes of modules  */
        $this->generateFile(

            'basic/provider-modules-routes-manager.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers\\Modules",
                '{{ class }}' => "RoutesManagerServiceProvider",
            ],
            "{$path}/App/Providers/Modules/RoutesManagerServiceProvider.php"
        );
        /* Register Event ServiceProvider file  */
        $this->generateFile(
            'basic/provider-event.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "EventServiceProvider",
                '{{ moduleLowerName }}' => 'cms',
            ],
            "{$path}/App/Providers/EventServiceProvider.php"
        );
        /* Register Route ServiceProvider file  */
        $this->generateFile(
            'basic/provider-route.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "RouteServiceProvider",
            ],
            "{$path}/App/Providers/RouteServiceProvider.php"
        );
        /* Register Abstract controller file  */
        $this->generateFile(
            'basic/controller-abstract.stub',
            [
                '{{$namespace}}' => "{$namespace}\\App\\Http\\Controllers",
            ],
            "{$path}/App/Http/Controllers/Controller.php"
        );
        /* Register config file  */
        $this->generateFile(
            'basic/config.stub',
            [],
            "{$path}/config/cms.php"
        );
        /* Register JS file  */
        $this->generateFile(
            'basic/js.stub',
            [],
            "{$path}/resources/js/scripts.js"
        );
        /* Register CSS file  */
        $this->generateFile(
            'basic/css.stub',
            [],
            "{$path}/resources/css/app.css"
        );
        /* Register master blade file  */
        $this->generateFile(
            'basic/view.stub',
            ['{{ quote }}' => Inspiring::quote()],
            "{$path}/resources/views/master.blade.php"
        );
        /* Register web route file  */
        $this->generateFile(
            'basic/route-web.stub',
            [],
            "{$path}/routes/web.php"
        );

        /* Register Seeder file file  */
        $this->generateFile(
            'basic/seeder.stub',
            [
                '{{ class }}' => "CmsDatabaseSeeder",

                '{{ namespace }}' => "{$namespace}\\Database\\Seeders",
            ],
            "{$path}/Database/Seeders/CmsDatabaseSeeder.php"
        );
    }

    private function generateFile(string $stub, array $replacements, string $destination): void
    {
        $this->replaceStub($stub, $replacements, $destination);
        $this->line("File: $destination is generated");
    }


    private function dumpingComposer(): void
    {
        $this->info("now wait to dump autoload of composer, it may take a while ...");

        Process::path(base_path())
            ->command('composer dump-autoload')
            ->run()->output();

    }

}
