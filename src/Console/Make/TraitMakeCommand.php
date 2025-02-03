<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Teksite\Lareon\Traits\CmsCommandsTrait;
use function Laravel\Prompts\select;

class TraitMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-trait {name}
         {--f|force : Create the test even if the test already exists }
    ';


    protected $description = 'Create a new trait in the cms';

    protected $type = 'Trait';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/trait.stub');
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
        return $this->setNamespace($name, '\\App\\Traits');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }

}
