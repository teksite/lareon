<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class MigrationMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:make-migration {name}
        {--create= : The table to be created }
        {--table= : The table to migrate }
        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file in the cms';


    public function handle()
    {
      return $this->generateMigration();
    }
    protected function generateMigration()
    {

        $cmsPath = Lareon::cmsPath(config('lareon.database.migration_path' , 'Database/Migrations'));

        if (!is_dir($cmsPath)){
            File::makeDirectory($cmsPath , '0755' , true);
        }
        $relativeBase=str_replace(base_path() , '', $cmsPath);
        $options = [
            'name' => $this->argument('name'),
            '--table' => $this->option('table') ,
            '--create' => $this->option('create'),
            '--path' =>$relativeBase,
        ];
        $this->call('make:migration', $options);
    }


    protected function getStub()
    {
       // Leave gere empty. stubs are read from laravel
    }
}
