<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Teksite\Lareon\Traits\CmsCommandsTrait;
use function Laravel\Prompts\suggest;

class ListenerMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait, CreatesMatchingTest;

    protected $signature = 'cms:make-listener {name}
        {--e|event= : The event class being listened  for}
        {--f|force : Create the class even if the listener already exists }
        {--queued : Indicates the event listener should be queued }
    ';

    protected $description = 'Create a new listener in the cms';

    protected $type = 'Listener';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('queued')) {
            return $this->option('event')
                ? $this->resolveStubPath('/listener.typed.queued.stub')
                : $this->resolveStubPath('/listener.queued.stub');
        }

        return $this->option('event')
            ? $this->resolveStubPath('/listener.typed.stub')
            : $this->resolveStubPath('/listener.stub');

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
        return $this->setNamespace($name, '\\App\\Listeners');
    }

    protected function buildClass($name)
    {
        $event = $this->option('event') ?? '';

        if (!Str::startsWith($event, [
            $this->cmsNamespace(),
            $this->cmsNamespace(),
            $this->cmsNamespace('App\\Events\\'),
        ])) {
            $event = $this->cmsNamespace('App\\Events\\') . '\\' . str_replace('/', '\\', $event);
        }

        $stub = str_replace(
            ['DummyEvent', '{{ event }}'], class_basename($event), parent::buildClass($name)
        );

        return str_replace(
            ['DummyFullEvent', '{{ eventNamespace }}'], trim($event, '\\'), $stub
        );
    }

    public function handle(): bool|int|null
    {
        return parent::handle();
    }

    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        if ($this->isReservedName($this->getNameInput()) || $this->didReceiveOptions($input)) {
            return;
        }

        $event = suggest(
            'What event should be listened for? (Optional)',
            $this->possibleEvents(),
        );

        if ($event) {
            $input->setOption('event', $event);
        }
    }


}
