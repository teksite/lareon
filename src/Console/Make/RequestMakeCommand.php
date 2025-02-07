<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class RequestMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'lareon:make-request {name}
         {--f|force : Create the class even if the cast already exists }
         {--api : return json } ';


    protected $description = 'Create a new request class in the cms';

    protected $type = 'Request';

    protected function getStub()
    {
        return $this->option('api')
            ? $this->resolveStubPath('/request-api.stub')
            : $this->resolveStubPath('/request.stub');
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
        return $this->setNamespace($name, '\\App\\Http\\Requests');

    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }


}
