<?php namespace Orchestra\Lumenate;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Studio\Traits\PublishFilesTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    use PublishFilesTrait;

    /**
     * The input interface implementation.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $basePath = getcwd();
        $vendorPath = "{$basePath}/vendor";

        $paths = [
            "{$vendorPath}/orchestra/lumenate/lumen" => "{$basePath}/lumen",
        ];

        $this->publishFiles(new Filesystem(), $paths, $input->getOption('force'));
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     *
     * @return void
     */
    public function error($string)
    {
        $this->output->writeln("<error>$string</error>");
    }

    /**
     * Write a string as standard output.
     *
     * @param  string  $string
     *
     * @return void
     */
    public function line($string)
    {
        $this->output->writeln($string);
    }

    /**
     * Write a status message to the console.
     *
     * @param  string  $from
     * @param  string  $to
     * @param  string  $type
     *
     * @return void
     */
    protected function status($from, $to, $type)
    {
        $from = trim(str_replace(getcwd(), '', realpath($from)), '/');
        $to   = trim(str_replace(getcwd(), '', realpath($to)), '/');

        $this->line('<info>Copied '.$type.'</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     *
     * @return $this
     */
    protected function replaceNamespace($stub)
    {
        return $stub;
    }
}
