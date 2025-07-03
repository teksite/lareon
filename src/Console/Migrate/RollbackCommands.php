<?php

namespace Teksite\Lareon\Console\Migrate;

use Teksite\Lareon\Console\BasicMigrator;
use Teksite\Lareon\Contract\MigrationContract;


class RollbackCommands extends BasicMigrator implements MigrationContract
{

    protected $signature = 'lareon:migrate-rollback
    {--module : rollback all modules }
    {--only=false : only migration manged by lareon}
    {--step=1}
    ';

    protected $description = 'Rollback the migrations for a specific module or all modules';


    public function runTheCommand()
    {
        $this->rollback($this->option('step'));
    }
}
