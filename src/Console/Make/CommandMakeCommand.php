<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class CommandMakeCommand extends GeneratorCommand
{
    use  CmsCommandsTrait;

    protected $signature = 'lareon:make-command {name}
         {--f|force : Create the class even if the console command already exists }
         {--command : he terminal command that will be used to invoke the class }
         ';

    protected $description = 'Create a new custom command class in the cms';

    protected $type = 'Command';

    protected function getStub()
    {
        return $this->resolveStubPath('/console.stub');
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
        return $this->setNamespace($name, '\\App\\Console\\Command');
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $command = $this->option('command') ?: 'app:' . (new Stringable($name))->classBasename()->kebab()->value();

        return str_replace(['dummy:command', '{{ command }}'], $command, $stub);
    }

    public function handle(): bool|int|null
    {
        return parent::handle();
    }

}
