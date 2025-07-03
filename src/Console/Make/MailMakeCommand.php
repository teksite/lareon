<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Teksite\Lareon\Traits\CmsCommandsTrait;
use function Laravel\Prompts\select;

class MailMakeCommand extends GeneratorCommand
{
    use CmsCommandsTrait, CreatesMatchingTest;

    // protected $name = 'lareon:make-mail';
    protected $signature = 'lareon:make-mail {name}
    {--force= : Create a new Blade template for the mailable (true false) }
    {--m|markdown= : Create a new Markdown template for the mailable }
    {--view= : Create a new Blade template for the mailable }
    ';

    protected $description = 'Create a new email in the cms';

    protected $type = 'Mailable';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (!!$this->option('markdown') !== false) {
            return $this->resolveStubPath('/markdown-mail.stub');
        }

        if (!!$this->option('view') !== false) {
            return $this->resolveStubPath('/view-mail.stub');
        }

        return $this->resolveStubPath('/mail.stub');

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
        return $this->setNamespace($name, '\\App\\Mail');
    }


    public function handle()
    {
        return $this->generateViews();
    }

    protected function generateViews()
    {
        if (parent::handle() === false && !!!$this->option('force')) {
            return;
        }

        if (!!$this->option('markdown') !== false) {
            return $this->writeMarkdownTemplate();
        }

        if (!!$this->option('view') !== false) {
            return $this->writeView();
        }
    }

    /**
     * Write the Markdown template for the mailable.
     *
     * @return void
     */
    protected function writeMarkdownTemplate()
    {
        $path = $this->viewPath(
            str_replace('.', '/', $this->getView()) . '.blade.php'
        );

        if ($this->files->exists($path)) {
            return $this->components->error(sprintf('%s [%s] already exists.', 'Markdown view', $path));
        }

        $this->files->ensureDirectoryExists(dirname($path));

        $this->files->put($path, file_get_contents(__DIR__ . '/../../stubs/markdown.stub'));

        $this->components->info(sprintf('%s [%s] created successfully.', 'Markdown view', $path));
    }

    /**
     * Write the Blade template for the mailable.
     *
     * @return void
     */
    protected function writeView()
    {
        $path = $this->viewPath(
            str_replace('.', '/', $this->getView()) . '.blade.php'
        );

        if ($this->files->exists($path)) {
            return $this->components->error(sprintf('%s [%s] already exists.', 'View', $path));
        }

        $this->files->ensureDirectoryExists(dirname($path));

        $stub = str_replace(
            '{{ quote }}',
            Inspiring::quotes()->random(),
            file_get_contents(__DIR__ . '/../../stubs/view.stub')
        );

        $this->files->put($path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', 'View', $path));
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {

        $class = str_replace(
            '{{ subject }}',
            Str::headline(str_replace($this->getNamespace($name) . '\\', '', $name)),
            parent::buildClass($name)
        );

        if (!!$this->option('markdown') !== false || !!$this->option('view') !== false) {
            $class = str_replace(['DummyView', '{{ view }}'], 'cms' . '::' . $this->getView(), $class);
        }

        if (!!!$this->option('markdown') || !!!$this->option('view')) {
            $class = str_replace(['DummyView', '{{ view }}'], $this->getView(), $class);
        }
        return $class;
    }

    /**
     * Get the view name.
     *
     * @return string
     */
    protected function getView()
    {
        $view = $this->option('markdown') ?: $this->option('view');

        if (!$view) {
            $name = str_replace('\\', '/', $this->argument('name'));

            $view = 'cms::mail.' . (new Collection(explode('/', $name)))
                    ->map(fn($part) => Str::kebab($part))
                    ->implode('.');
        }
        return $view;


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

        $type = select('Would you like to create a view?', [
            'markdown' => 'Markdown View',
            'view' => 'Empty View',
            'none' => 'No View',
        ]);

        if ($type !== 'none') {
            $input->setOption($type, null);
        }
    }
}
