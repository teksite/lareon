<?php

namespace Teksite\Lareon\Console\Migrate;

use Teksite\Lareon\Console\BasicMigrator;
use Teksite\Lareon\Contract\MigrationContract;

class MigrateCommands extends BasicMigrator implements MigrationContract
{

    protected $signature = 'lareon:migrate
    {--module : migrating all modules }
    {--seed}
    {--only=false : only migration manged by lareon}
    ';

    protected $description = 'Run the migrations for a specific module or all modules';


    public function runTheCommand(): void
    {
        $this->up();

        if ($this->option('seed')) {
            $this->seeding();
            if ($this->option('modules')) {
                $this->seedingModules();
            }
        }
    }

}
