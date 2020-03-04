<?php

namespace Orchestra\Lumenate;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    use InteractsWithIO,
        Concerns\PublishFiles;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('make')
            ->setDescription('Make Lumen skeleton into the current project.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Overwrite any existing files.');
    }

    /**
     * Execute the command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput(new OutputStyle($input, $output));

        $filesystem = new Filesystem();

        $this->publishFiles(
            $filesystem, $this->getInstallationPaths($filesystem), $input->getOption('force')
        );

        return 0;
    }

    /**
     * Get installation paths from lumen.json file.
     */
    protected function getInstallationPaths(Filesystem $filesystem): array
    {
        $basePath = \getcwd();
        $vendorPath = "{$basePath}/vendor/orchestra/lumen/skeleton";
        $paths = [];

        if (! $filesystem->isFile($schema = "{$basePath}/lumen.json")) {
            $schema = "{$vendorPath}/lumen.json";
        }

        $paths = \json_decode($filesystem->get($schema), true);

        if (\is_null($paths)) {
            return ["{$vendorPath}" => "{$basePath}/lumen"];
        }

        $paths = \array_map(static function ($path) use ($vendorPath) {
            return "{$vendorPath}/{$path}";
        }, \array_flip($paths));

        return \array_map(static function ($path) use ($basePath) {
            return "{$basePath}/{$path}";
        }, \array_flip($paths));
    }

    /**
     * Replace the namespace for the given stub.
     */
    protected function replaceNamespace(string $stub): string
    {
        return $stub;
    }
}
