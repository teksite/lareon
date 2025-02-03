<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class FactoryMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    protected $signature = 'cms:make-factory {name}
        {--model= : The name of the model}
    ';

    protected $description = 'Create a new factory class in the cms';

    protected $type = 'Factory';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/factory.stub');
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
        return $this->setNamespace($name, '\\Database\\Factories');
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */

    protected function buildClass($name)
    {
        $factory = class_basename(Str::ucfirst(str_replace('Factory', '', $name)));

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel($this->option('model'))
            : $this->qualifyModel($this->guessModelName($name));

        $model = class_basename($namespaceModel);

        $namespace = $this->getNamespace(
            Str::replaceFirst($this->rootNamespace(), 'Database\\Factories\\', $this->qualifyClass($this->getNameInput()))
        );

        $replace = [
            '{{ factoryNamespace }}' => $namespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            '{{ factory }}' => $factory,
            '{{factory}}' => $factory,
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }


    public function handle(): bool|int|null
    {
        return parent::handle();
    }

    protected function guessModelName($name)
    {
        if (str_ends_with($name, 'Factory')) {
            $name = substr($name, 0, -7);
        }

        $modelName = $this->qualifyModel(Str::after($name, $this->rootNamespace()));

        if (class_exists($modelName)) {
            return $modelName;
        }

        if (is_dir(app_path('Models/'))) {
            return $this->rootNamespace() . 'Models\Model';
        }

        return $this->rootNamespace() . 'Model';
    }

}
