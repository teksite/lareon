<?php

namespace Teksite\Lareon\Traits\Migration;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Teksite\Module\Traits\Migration\ModuleMigrationTrait;

trait LareonMigrationTrait
{
    use ModuleMigrationTrait;

    /**
     * @return void
     */
    public function downLareon(): void
    {
        $this->warn("Dropping all tables of lareon");
        $this->runAndCalculate(function () {
            foreach (array_reverse($this->lareonMigrationFiles()) as $migration) {
                $class = $this->resolve($migration['path']);
                $class->down();
                $this->removeFromMigrationTable($migration['name']);
            }
        }, "lareon tables");

    }

    /**
     * @param int|null $batch
     * @return void
     */
    public function upLareon(?int $batch = null): void
    {
        $this->warn("migrating all tables of lareon");

        $batch = $batch ?? DB::table('migrations')->max('batch') + 1;
        $migrationsRecords = $this->migrationTableRecord();
        foreach ($this->lareonMigrationFiles() as $migration) {
            if (!in_array($migration['name'], $migrationsRecords)) {
                $this->runAndCalculate(function () use ($batch, $migration) {
                    $class = $this->resolve($migration['path']);
                    $class->up();
                    $this->addToMigrationTable($migration['name'], $batch);
                }, $migration['name']);
            }
        }
    }

    /**
     * @return array
     */
    public function lareonMigrationFiles(): array
    {
        $migrationsPath = cms_path('Database/Migrations');
        $migration_list = File::allFiles($migrationsPath);
        $migrations = [];
        foreach ($migration_list as $key => $migrateFile) {
            $absPath = $migrateFile->getPathname();
            $fileName = $migrateFile->getFilename();
            $migrationName = str_replace('.php', '', $fileName);
            $migrations[$key]['path'] = $absPath;
            $migrations[$key]['file'] = $fileName;
            $migrations[$key]['name'] = $migrationName;
        }
        return $migrations;
    }

    /**
     * @return void
     */
    public function seedingLareon(): void
    {
        $this->warn('seeding lareon');
        $mainSeeder = cms_namespace("Database\\Seeders\\CmsDatabaseSeeder");
        if (class_exists($mainSeeder)) {
            $this->runAndCalculate(function () use ($mainSeeder) {
                $this->call($mainSeeder);
            },'seeding lareon');
        }
    }
}
