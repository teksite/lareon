<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class JobMiddlewareMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait, CreatesMatchingTest;

    protected $signature = 'cms:make-job-middleware {name}
    ';

    protected $description = 'Create a new middleware for jobs in the cms';

    protected $type = 'Middleware';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/job.middleware.stub');
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
        return $this->setNamespace($name, '\\App\\Jobs\\Middleware');
    }


    public function handle(): bool|int|null
    {
        return parent::handle();

    }

}
