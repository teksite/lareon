<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class RuleMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-rule {name}
     {--f|force : Create the class even if the resource already exists },
     {--i|implicit : Generate an implicit rule },
    ';


    protected $description = 'Create a new rule in the cms';

    protected $type = 'Rule';

    protected function getStub()
    {
        return $this->option('implicit')
            ? $this->resolveStubPath('/rule.implicit.stub')
            : $this->resolveStubPath('/rule.stub');
    }


    protected function getPath($name)
    {
        return $this->setPath($name, 'php');
    }

    /**
     * تنظیمات نام‌گذاری کلاس.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $this->setNamespace($name, '\\App\\Rules');
    }

    protected function buildClass($name)
    {
        return str_replace(
            '{{ ruleType }}',
            $this->option('implicit') ? 'ImplicitRule' : 'Rule',
            parent::buildClass($name)
        );
    }


    public function handle(): bool|int|null
    {
        return parent::handle();

    }

}
