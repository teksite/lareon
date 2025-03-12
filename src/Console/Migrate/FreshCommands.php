<?php

namespace Teksite\Lareon\Console\Migrate;

use Teksite\Lareon\Console\BasicMigrator;
use Teksite\Lareon\Contract\MigrationContract;

class FreshCommands extends BasicMigrator implements MigrationContract
{

    protected $signature = 'lareon:migrate-fresh
    {--module : fresh migrations of all modules }
    {--seed }
    {--only=false : only migration manged by lareon}
    ';

    protected $description = 'Drop all tables and re-run migrations of lareon';

    public function handle(): void
    {
        parent::handle();
        if ($this->option('seed')) $this->seeding();
    }

    public function runTheCommand(): void
    {
        $this->down();
        $this->up();

    }
}
