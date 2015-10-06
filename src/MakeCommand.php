<?php namespace Orchestra\Lumenate;

use Orchestra\Studio\Traits\PublishFilesTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    use PublishFilesTrait;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('make')
                ->setDescription('Make Lumen skeleton into the current project.');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $basePath = getcwd();
        $vendorPath = "{$basePath}/vendor";

        $paths = [
            "{$vendorPath}/orchestra/lumenate-installer/lumen" => "{$basePath}/lumen",
        ];

        $this->publishFiles(new Filesystem(), $paths. $this->getOption('force'));
    }
}
