<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class CastMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'lareon:make-cast {name}
         {--f|force : Create the class even if the cast already exists }
         {--inbound : Generate an inbound cast class }
        ';

    protected $description = 'Create a new cast class in the cms';

    protected $type = 'Cast';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->option('inbound')
            ? $this->resolveStubPath('/cast.inbound.stub')
            : $this->resolveStubPath('/cast.stub');
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
        return $this->setNamespace($name, '\\App\\Cast');
    }

    public function handle(): bool|int|null
    {

        return parent::handle();

    }
}
