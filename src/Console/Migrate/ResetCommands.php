<?php

namespace Teksite\Lareon\Console\Migrate;

use Teksite\Lareon\Console\BasicMigrator;
use Teksite\Lareon\Contract\MigrationContract;


class ResetCommands extends BasicMigrator implements MigrationContract
{

    protected $signature = 'lareon:migrate-reset
    {--module : fresh migrations of all modules }
    {--seed }
    {--only=false : only migration manged by lareon}
';

    protected $description = 'Rollback migrations for a specific module or all modules';

    public function runTheCommand(): void
    {
        $this->down();
    }
}
