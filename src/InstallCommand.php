<?php

namespace Orchestra\Lumenate;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    use InteractsWithIO;

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
            ->addArgument('version', InputArgument::OPTIONAL, 'Install Lumen using following version', '5.0');
    }

    /**
     * Execute the command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput($outputStyle = new OutputStyle($input, $output));

        $version = $input->getArgument('version') ?? '4.0';

        $process = Process::fromShellCommandline($this->findComposer().' require "orchestra/lumen=^'.$version.'"', null, null, null, null);

        $process->run(static function ($type, $line) use ($outputStyle) {
            $outputStyle->write($line);
        });

        return 0;
    }

    /**
     * Get the composer command for the environment.
     */
    private function findComposer(): string
    {
        if (\file_exists(\getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar"';
        }

        return 'composer';
    }
}
