<?php

namespace Teksite\Lareon\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Teksite\Lareon\Traits\Migration\LareonMigrationTrait;
use Teksite\Module\Facade\Module;
use Teksite\Module\Traits\Migration\ModuleMigrationTrait;


class BasicMigrator extends Command
{
    use LareonMigrationTrait;

    /**
     * @param $file
     * @return mixed
     */
    public function resolve($file): mixed
    {
        return class_exists($file) ? new $file : include $file;
    }
    
    /**
     * @return void
     */
    public function down(): void
    {
        $this->downLareon();
        if ($this->option('module')) $this->downModules();
    }

    /**
     * @return void
     */
    public function up(): void
    {
        $batch = $batch ?? DB::table('migrations')->max('batch') + 1;

        $this->upLareon($batch);
        if ($this->option('module')) $this->upModules($batch);

    }

    /**
     * @param int $step
     * @return void
     */
    public function rollback(int $step = 1): void
    {
        $lareonMigrations = collect($this->lareonMigrationFiles())->select(['path', 'name', 'path']);
        $modulesMigration = $this->option('module') ? collect($this->moduleMigrationFiles())->select(['path', 'name', 'path']) : null;
        $migrationTables = $lareonMigrations->merge($modulesMigration);

        $this->rollingBackMigration($migrationTables, $step);
    }

    /**
     * @param string $migrateFileName
     * @return void
     */
    public function removeFromMigrationTable(string $migrateFileName): void
    {
        DB::table('migrations')->where('migration', $migrateFileName)->delete();

    }

    /**
     * @param string $migrateFileName
     * @param $batch
     * @return void
     */
    public function addToMigrationTable(string $migrateFileName, $batch = 1): void
    {
        DB::table('migrations')->insert([
            'migration' => $migrateFileName,
            'batch' => $batch,
        ]);
    }

    /**
     * @return void
     */
    public function installMigrateTable(): void
    {
        Schema::hasTable('migrations') ?: $this->call('migrate:install');
    }

    /**
     * @return void
     */
    public function seeding(): void
    {
        $this->seedingLareon();
        if ($this->option('module')) $this->seedingModules();
    }

    /**
     * @return array
     */
    public function getModules(): array
    {
        return Module::all();
    }

}
