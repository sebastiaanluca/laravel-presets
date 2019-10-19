<?php

namespace SebastiaanLuca\Preset\Presets;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;
use SebastiaanLuca\Preset\Concerns\ExecutesShellCommands;

abstract class Preset extends BasePreset
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

    /**
     * @param \Illuminate\Foundation\Console\PresetCommand $command
     */
    public static function install(PresetCommand $command) : void
    {
        (new static($command))->run();
    }

    /**
     * Run the preset.
     *
     * @return void
     */
    abstract public function run() : void;
}
