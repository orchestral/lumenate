<?php

namespace Orchestra\Lumenate;

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
                ->setDescription('Install Lumen into the current project.')
                ->addOption('version', null, InputOption::VALUE_OPTIONAL, 'Install Lumen using following version', '4.0');
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $version = $input->getOption('version');

        $process = new Process($this->findComposer().' require "orchestra/lumen=^'.$version.'"', null, null, null, null);

        $process->run(static function ($type, $line) use ($output) {
            $output->write($line);
        });
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer(): string
    {
        if (\file_exists(\getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar"';
        }

        return 'composer';
    }
}
