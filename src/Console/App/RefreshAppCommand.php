<?php

namespace Teksite\Lareon\Console\App;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\GeneralCommandsTrait;

class RefreshAppCommand extends Command
{
    use GeneralCommandsTrait;

    protected $signature = 'app:refresh
                            {--admin=no : need to make a administrator (yes/no) }
                            {--restore : restore backup data (single/no) };
                            {--seeding : seeding }
                            {--path=storage/backups : backup path to restore from }
                            {--prevent-migration : prevent migrating after drop all tables }';

    protected $description = 'reset all tables then migrate, seed and restore data';

    public function handle()
    {

        $admin = $this->option('admin');
        $doRestore = $this->option('restore');
        $backupPath = base_path($this->option('path'));

        $db = [
            'connection' => env('DB_CONNECTION'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];
        Artisan::call('migrate:reset', outputBuffer: $this->output);


        if (!$this->option('prevent-migration')) {
            $this->warn('Migrating database');
            Artisan::call('migrate', outputBuffer: $this->output);
        }
        if ($this->option('seeding')) {
            Artisan::call('lareon:seed --module', outputBuffer: $this->output);
            $this->warn('extra seeding');
            Artisan::call('db:seed', outputBuffer: $this->output);
        }

        if ($doRestore) {
            if (is_dir($backupPath)) {
                $files = File::allFiles($backupPath);
                if (count($files) > 0) {
                    $this->line('restoring backup data:');

                    foreach ($files as $file) {
                        $fileName = $file->getBasename();
                        $path = $file->getPathname();
                        $this->print(function () use ($path, $db) {
                            DB::unprepared(file_get_contents($path));
                       // exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $path");
                        }, "$fileName");
                    }
                    $this->newLine();
                }
            }
        }

        Artisan::call('optimize:clear');
        $this->line('optimize is cleared successfully!');

        Artisan::call('config:clear');
        $this->line('configs are cleared successfully!');

        Artisan::call('route:clear');
        $this->line('routes are cleared successfully!');

        Artisan::call('view:clear');
        $this->line('views are cleared successfully!');

        Artisan::call('cache:clear');
        $this->line('caches are cleared successful!');

        $this->newLine();
        $this->alert('The site is refreshed successfully :)');

        if ($admin === 'yes') $this->call('lareon:make-admin');
    }

}
