<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Teksite\Lareon\Traits\CmsCommandsTrait;
use function Laravel\Prompts\confirm;

class ExceptionMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'lareon:make-exception {name}
        {--f|force : Create the class even if the event already exists }
        {--render : Create the exception with an empty render method}
        {--report : Create the exception with an empty report method}
    ';

    protected $description = 'Create a new exception in the cms';

    protected $type = 'Exception';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('render')) {
            return $this->option('report')
                ? $this->resolveStubPath('/exception-render-report.stub')
                : $this->resolveStubPath('/exception-render.stub');
        }
        return $this->option('report')
            ? $this->resolveStubPath('/exception-report.stub')
            : $this->resolveStubPath('/exception.stub');
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
        return $this->setNamespace($name, '\\App\\Exceptions');

    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        if ($this->didReceiveOptions($input)) {
            return;
        }

        $input->setOption('report', confirm('Should the exception have a report method?', default: false));
        $input->setOption('render', confirm('Should the exception have a render method?', default: false));
    }


    public function handle(): bool|int|null
    {
        return parent::handle();

    }
}
