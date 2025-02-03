<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class PolicyMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-policy {name}
        {--f|force= : Create the class even if the policy already exists }
        {--m|model= : The model that the policy applies to }
        {--g|guard= : The guard that the policy relies on }
    ';

    protected $description = 'Create a new policy in the cms';

    protected $type = 'Policy';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('model')
            ? $this->resolveStubPath('/policy.stub')
            : $this->resolveStubPath('/policy.plain.stub');
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
        return $this->setNamespace($name, '\\App\\Policies');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();

    }

    protected function buildClass($name)
    {
        $stub = $this->replaceUserNamespace(
            parent::buildClass($name)
        );

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        if (str_starts_with($model, '\\')) {
            $namespacedModel = trim($model, '\\');
        } else {
            $namespacedModel = $this->qualifyModel($model);
        }

        $model = class_basename(trim($model, '\\'));

        $dummyUser = class_basename($this->userProviderModel());

        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        $replace = [
            'NamespacedDummyModel' => $namespacedModel,
            '{{ namespacedModel }}' => $namespacedModel,
            '{{namespacedModel}}' => $namespacedModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            'dummyModel' => Str::camel($dummyModel),
            '{{ modelVariable }}' => Str::camel($dummyModel),
            '{{modelVariable}}' => Str::camel($dummyModel),
            'DummyUser' => $dummyUser,
            '{{ user }}' => $dummyUser,
            '{{user}}' => $dummyUser,
            '$user' => '$' . Str::camel($dummyUser),
        ];

        $stub = str_replace(
            array_keys($replace), array_values($replace), $stub
        );

        return preg_replace(
            vsprintf('/use %s;[\r\n]+use %s;/', [
                preg_quote($namespacedModel, '/'),
                preg_quote($namespacedModel, '/'),
            ]),
            "use {$namespacedModel};",
            $stub
        );
    }

    protected function replaceUserNamespace($stub)
    {
        $model = $this->userProviderModel();

        if (!$model) {
            return $stub;
        }

        return str_replace(
            $this->rootNamespace() . 'User',
            $model,
            $stub
        );
    }

}
