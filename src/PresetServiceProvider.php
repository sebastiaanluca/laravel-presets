<?php

namespace sixlive\LaravelPreset;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/preset.php', 'preset');

        PresetCommand::macro('sebastiaanluca', static function ($command) : void {
            Preset::install($command);
        });
    }
}
