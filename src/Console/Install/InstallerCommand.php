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

        /* Register ServiceProvider file  */
        $this->generateFile(
            'basic/provider.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "{$moduleName}ServiceProvider",
                '{{ module }}' => $moduleName,
                '{{ moduleLowerName }}' => strtolower($moduleName),

            ],
            "{$path}/App/Providers/{$moduleName}ServiceProvider.php"
        );
        /* Register Event ServiceProvider file  */
        $this->generateFile(
            'basic/provider-event.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "EventServiceProvider",
                '{{ moduleLowerName }}' => strtolower($moduleName),
                '{{ module }}' => $moduleName,
            ],
            "{$path}/App/Providers/EventServiceProvider.php"
        );
        /* Register Route ServiceProvider file  */
        $this->generateFile(
            'basic/provider-route.stub',
            [
                '{{ namespace }}' => "{$namespace}\\App\\Providers",
                '{{ class }}' => "RouteServiceProvider",
                '{{ moduleLowerName }}' => strtolower($moduleName),
                '{{ module }}' => $moduleName,
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
            [
                '{{ module }}' => $moduleName,
            ],
            "{$path}/config/config.php"
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
            ['{{ module }}' => strtolower($moduleName)],
            "{$path}/routes/web.php"
        );

        /* Register Seeder file file  */
        $this->generateFile(
            'basic/seeder.stub',
            [
                '{{ module }}' => strtolower($moduleName),
                '{{ namespace }}' => "{$namespace}\\Database\\Seeders",
                '{{ class }}' => "{$moduleName}DatabaseSeeder",
            ],

            "{$path}/Database/Seeders/{$moduleName}DatabaseSeeder.php"
        );

        /* Register Seeder file file  */
        $this->generateFile(
            'basic/info.stub',
            [
                '{{ name }}' => $moduleName,
                '{{ alias }}' => strtolower($moduleName),
                '{{ providers }}' => str_replace('\\', '\\\\', "$namespace\App\Providers\\" . $moduleName . "ServiceProvider"),
            ],

            "{$path}/info.json"
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

}
