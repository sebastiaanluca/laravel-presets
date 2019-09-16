<?php

namespace SebastiaanLuca\LaravelPreset;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/preset.php', 'preset');

        PresetCommand::macro('sebastiaanluca', static function (Command $command) : void {
            Preset::install($command);
        });
    }
}
