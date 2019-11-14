<?php

namespace Orchestra\Lumenate\Concerns;

use League\Flysystem\MountManager;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Local as LocalAdapter;

trait PublishFiles
{
    /**
     * Publish files.
     *
     * @param  bool  $force
     *
     * @return void
     */
    protected function publishFiles(Filesystem $filesystem, array $paths, $force = false)
    {
        foreach ($paths as $from => $to) {
            if ($filesystem->isFile($from)) {
                $this->publishFile($filesystem, $from, $to, $force);
            } elseif ($filesystem->isDirectory($from)) {
                $this->publishDirectory($from, $to, $force);
            } else {
                $this->error("Can't locate path: <{$from}>");
            }
        }
    }

    /**
     * Publish the file to the given path.
     *
     * @param  string  $from
     * @param  string  $to
     * @param  bool  $force
     *
     * @return void
     */
    protected function publishFile(Filesystem $filesystem, $from, $to, $force = false)
    {
        if ($filesystem->exists($to) && ! $force) {
            return;
        }

        $content = $this->replaceNamespace($filesystem->get($from));

        $this->createParentDirectory($filesystem, dirname($to));
        $filesystem->put($to, $content);

        $this->status($from, $to, 'File');
    }

    /**
     * Publish the directory to the given directory.
     *
     * @param  string  $from
     * @param  string  $to
     * @param  bool  $force
     *
     * @return void
     */
    protected function publishDirectory($from, $to, $force = false)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]);

        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (! $manager->has('to://'.$file['path']) || $force)) {
                $content = $this->replaceNamespace($manager->read('from://'.$file['path']));

                $manager->put('to://'.$file['path'], $content);
            }
        }

        $this->status($from, $to, 'Directory');
    }

    /**
     * Create the directory to house the published files if needed.
     *
     * @param  string  $directory
     *
     * @return void
     */
    protected function createParentDirectory(Filesystem $filesystem, $directory)
    {
        if (! $filesystem->isDirectory($directory)) {
            $filesystem->makeDirectory($directory, 0755, true);
        }
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
        $from = \str_replace(\base_path(), '', \realpath($from));
        $to = \str_replace(\base_path(), '', \realpath($to));

        $this->line("<info>Copied {$type}</info> <comment>[{$from}]</comment> <info>To</info> <comment>[{$to}]</comment>");
    }

    /**
     * Write a string as error output.
     *
     * @param  int|string|null  $verbosity
     */
    abstract public function error(string $string, $verbosity = null): void;

    /**
     * Write a string as standard output.
     */
    abstract public function line(string $string, ?string $style = null): void;

    /**
     * Replace the namespace for the given stub.
     *
     * @return $this
     */
    abstract protected function replaceNamespace(string $stub): string;
}
