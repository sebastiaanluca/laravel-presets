<?php

namespace SebastiaanLuca\LaravelPreset;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;

class PackagePreset extends BasePreset
{
    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    /**
     * @param \Illuminate\Console\Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param \Illuminate\Console\Command $command
     */
    public static function install(Command $command) : void
    {
        (new static($command))->run();
    }

    /**
     * @return void
     */
    public function run() : void
    {
        $this->command->info('Package successfully scaffolded.');
    }
}
