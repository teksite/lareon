<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Teksite\Lareon\Traits\CmsCommandsTrait;

class ChannelMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lareon:make-channel {name}
        --f|force : Create the class even if the cast already exists }
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file in the cms';

    protected $type = 'Migration';

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        return str_replace(
            ['DummyUser', '{{ userModel }}'],
            class_basename($this->userProviderModel()),
            parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/channel.stub');
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

        return $this->setNamespace($name, '\\App\\Broadcasting');
    }

    public function handle(): bool|int|null
    {
        return parent::handle();
    }


}
