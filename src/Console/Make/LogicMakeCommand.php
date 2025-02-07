<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class LogicMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait, CreatesMatchingTest;

    protected $signature = 'lareon:make-logic {name} ';


    protected $description = 'Create a new logic class (repository and logic layer) in the cms';

    protected $type = 'Logic';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/logic-class.stub');
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {

        return $this->setPath($name, 'php');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name): string
    {
        return $this->setNamespace($name, '\\App\\Logic');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();
    }
}
