<?php namespace Orchestra\Lumenate;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('install')
                ->setDescription('Install Lumen into the current project.');
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
        $composer = $this->findComposer();

        $process = new Process($composer . ' require "orchestra/lumen=~3.1"', null, null, null, null);

        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" composer.phar"';
        }

        return 'composer';
    }
}
