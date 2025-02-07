<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class ClassMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lareon:make-class {name}
        {--f|force : Create the class even if the cast already exists }
        {--i|invokable : Generate a single method, invokable class }
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new classin the cms';

    protected $type = 'Class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->option('invokable')
            ? $this->resolveStubPath('/class.invokable.stub')
            : $this->resolveStubPath('/class.stub');
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
        return $this->setNamespace($name, '\\App');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }


}
