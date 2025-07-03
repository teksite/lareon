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

    protected $description = 'install lareon and cms';

    protected $type = 'Install';

    public function handle()
    {

        $cmsPath = cms_path();
        if (is_dir($cmsPath)) {
            $this->error("a directory with name Cms is already existed in $cmsPath");
            return;
        }

       $this->createDirectories($cmsPath);

        $this->createFiles($cmsPath);
        $this->dumpingComposer();

        $this->output->getFormatter()->setStyle('success', new OutputFormatterStyle('black', 'blue', ['bold']));
        $this->newLine();

        $this->info("<success>SUCCESS</success> Lareon is installed successfully.");
    }

    private function createDirectories(string $path): void
    {
        $directories = [
            '',
            'App',
            'App/Http',
            'App/Http/Controllers',
            'App/Models',
            'App/Providers',
            'config',
            'Database',
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

        foreach ($directories as $directory) {
            File::makeDirectory($path . DIRECTORY_SEPARATOR . $directory, 0755, true);
            $this->components->twoColumnDetail("Directory: <fg=white;options=bold>$directory</>", '<fg=green;options=bold>DONE</>');
        }
    }

    private function createFiles(string $path): void
    {
        $namespace = cms_namespace();
        $cmsPath = cms_path(absolute: false);
        $moduleName = 'Lareon';
        $composerContent =file_get_contents(base_path('composer.json'));
        $version= json_decode($composerContent,true)['require']['teksite/lareon'] ?? "1.0.0";

        /* Register Composer file  */
        $this->generateFile(
            'basic/composer.stub',
            [
                '{{ moduleLowerName }}' => strtolower($moduleName),
                '{{ moduleName }}' => 'Lareon',
                '{{ modulePath }}' => str_replace("\\", '/', $cmsPath),
                '{{ namespace }}' => str_replace("\\", '\\\\', $namespace),
            ],
            "{$path}/composer.json"
        );

        /* create info.json  */
        $this->generateFile(
            'basic/info.stub',
            [
                '{{ version }}' => $version,
            ],
            "{$path}/info.json"
        );


        /* Register ServiceProvider file  */
        $this->generateFile(
            'basic/cms-service-provider.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "CmsServiceProvider",
            ],
            "{$path}/App/Providers/CmsServiceProvider.php"
        );

        /* Register ServiceProvider of modules  */
        $this->generateFile(
            'basic/module-manager-service-provider.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers\\Modules",
                '{{ class }}' => "ModulesManagerServiceProvider",
            ],
            "{$path}/App/Providers/Modules/ModulesManagerServiceProvider.php"
        );

        /* Register ServiceProvider of routes of modules  */
        $this->generateFile(

            'basic/modules-routes-manager-service-provider.stub',
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
            'basic/cms-config.stub',
            [],
            "{$path}/config/lareon.php"
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

        /* Register Seeder file file  */
        $this->generateFile(
            'basic/seeder.stub',
            [
                '{{ class }}' => "CmsDatabaseSeeder",

                '{{ namespace }}' => "{$namespace}\\Database\\Seeders",
            ],
            "{$path}/Database/Seeders/CmsDatabaseSeeder.php"
        );

        foreach ($this->routes() as $route)
            // Routes
            $this->generateFile(
                'basic/route.stub',
                [],
                "{$path}/routes/$route"
            );
    }

    private function generateFile(string $stub, array $replacements, string $destination): void
    {
        $this->replaceStub($stub, $replacements, $destination);
        $relativePath = str_replace(base_path(), '', $destination);
        $this->components->twoColumnDetail("File: <fg=white;options=bold>$relativePath</>", '<fg=green;options=bold>DONE</>');

    }


    private function dumpingComposer(): void
    {
        $this->info("wait to dump autoload of composer, it may take a while ...");

        Process::path(base_path())
            ->command('composer dump-autoload')
            ->run()->output();

    }

    private function routes()
    {
        return [
            'admin/web.php', 'admin/ajax.php', 'admin/api.php',

            'panel/web.php', 'admin/ajax.php', 'admin/api.php',

            'auth/web.php', 'auth/ajax.php', 'auth/api.php',

            'web.php', 'ajax.php', 'api.php',


        ];


    }


}
