<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class InterfaceMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-interface {name}
         {--f|force : Create the class even if the cast already exists }
    ';

    protected $description = 'Create a new interface in the cms';

    protected $type = 'Interface';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/interface.stub');
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
        return $this->setNamespace($name, '\\App\\Interfaces');
    }


    public function handle(): bool|int|null
    {
        return parent::handle();

    }

}
