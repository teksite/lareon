<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class JobMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait, CreatesMatchingTest;

    protected $signature = 'cms:make-job {name}
     {--f|force : Create the class even if the job already exists }
     {--sync : Indicates that job should be synchronous }
    ';

    protected $description = 'Create a new job in the cms';

    protected $type = 'Job';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->option('sync')
            ? $this->resolveStubPath('/job.stub')
            : $this->resolveStubPath('/job.queued.stub');
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
        return $this->setNamespace($name, '\\App\\Jobs');
    }


    public function handle(): bool|int|null
    {
        return parent::handle();

    }

}
