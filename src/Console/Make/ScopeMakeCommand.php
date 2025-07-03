<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class ScopeMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'lareon:make-scope {name}
     {--f|force : Create the class even if the resource already exists },
    ';


    protected $description = 'Create a new scope in the cms';

    protected $type = 'Scope';

    protected function getStub()
    {
        return $this->resolveStubPath('/scope.stub');
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
        return $this->setNamespace($name, '\\App\\Models\\Scopes');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }


}
