<?php

namespace Teksite\Lareon\Console\App;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\GeneralCommandsTrait;

class RefreshAppCommand extends Command
{
    use GeneralCommandsTrait;

    protected $signature = 'lareon:refresh
                            {--admin=no : need to make a superadmin (yes/no)}
                            {--single=yes : use single files backup files instead of bulk file  (yes/no)}';

    protected $description = 'reset all tables then migrate, seed and restore data';

    public function handle()
    {
        $progressbar = $this->output->createProgressBar();

        $admin = $this->option('admin');
        $single = $this->option('single');
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];

        $this->print(function () {
            Artisan::call('migrate:fresh');
        }, 'resetting migration');

        if ($single === 'yes') {


            $this->print(function () {
                Artisan::call('migrate');
            }, 'refreshing migration');



            $this->print(function () {
                Artisan::call('lareon:seed');
            }, 'seeding cms');



            $this->print(function () {
            //    Artisan::call('module:seed');
            }, 'seeding modules');


            $this->print(function () {
                Artisan::call('db:seed');
            }, 'seeding laravel');



            if (is_dir(storage_path('backups/singles/'))) {


                $files = array_diff(scandir(storage_path('backups/singles/')), array('..', '.'));

                foreach ($files as $file) {
                    $this->line('restoring: ' . $file . '...');

                    $sql = storage_path('backups/singles/' . $file);

                    $this->print(function () use ($sql, $db) {
                        exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql",);
                    }, 'seeding laravel');


                }
            }

        } else {
            if (is_dir(storage_path('backups/'))) {
                $files = array_diff(scandir(storage_path('backups/')), array('..', '.'));
                $file = $files[2];
                $this->line('restoring: ' . $file . '...');
                $sql = storage_path('backups/' . $file);
                $this->print(function () use ($sql, $db) {
                    exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql",);
                }, 'seeding laravel');


            }

        }
        $this->info('data is restored successfully');


        if ($admin === 'yes') {

           // $this->call('lareon:make-superadmin');
        }



        Artisan::call('config:clear');
        $this->info('configs are cleared successfully!');

        Artisan::call('route:clear');
        $this->info('routes are cleared successfully!');

        Artisan::call('view:clear');
        $this->info('views are cleared successfully!');

        Artisan::call('cache:clear');
        $this->info('caches are cleared successful!');



        $progressbar->finish();
        $this->newLine();
        $this->alert('The site is refreshed successfully :)');
    }


    protected function getArguments(): array
    {
        return [
            ['admin', InputArgument::OPTIONAL, 'make a super admin user.'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
