<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Concerns;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

trait ExecutesShellCommands
{
    /**
     * @param string $command
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     */
    protected function call(string $command) : void
    {
        try {
            $process = new Process(
                explode(' ', $command),
                base_path()
            );

            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            if (! property_exists($this, 'command')) {
                throw $exception;
            }

            $this->command->error($exception->getMessage());
        }
    }
}
