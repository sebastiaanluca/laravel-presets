<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Foundation\Console\PresetCommand;
use SebastiaanLuca\Preset\ExecutesShellCommands;

abstract class Action
{
    use ExecutesShellCommands;

    /**
     * @var \Illuminate\Foundation\Console\PresetCommand
     */
    protected $command;

    /**
     * @param \Illuminate\Foundation\Console\PresetCommand $command
     */
    public function __construct(PresetCommand $command)
    {
        $this->command = $command;
    }
}
