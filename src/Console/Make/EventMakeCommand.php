<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class EventMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-event {name}
        {--f|force : Create the class even if the event already exists }
    ';

    protected $description = 'Create a new event class in the cms';

    protected $type = 'Event';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/event.stub');
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
        return $this->setNamespace($name, '\\App\\Events');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }
}
