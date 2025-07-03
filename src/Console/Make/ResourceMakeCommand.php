<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class ResourceMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'lareon:make-resource {name}
     {--f|force : Create the class even if the resource already exists },
     {--c|collection : Create a resource collection },
    ';


    protected $description = 'Create a new resource in the cms';

    protected $type = 'Resource';

    protected function getStub()
    {
        return $this->collection()
            ? $this->resolveStubPath('/resource-collection.stub')
            : $this->resolveStubPath('/resource.stub');
    }


    protected function getPath($name)
    {
        return $this->setPath($name,'php');
    }

    /**
     * تنظیمات نام‌گذاری کلاس.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $this->setNamespace($name , '\\App\\Http\\Resources');
    }

    public function handle(): bool|int|null
    {
        if ($this->collection()) {
            $this->type = 'Resource collection';
        }
       return parent::handle();


    }

    protected function collection()
    {
        return $this->option('collection') ||
            str_ends_with($this->argument('name'), 'Collection');
    }


}
