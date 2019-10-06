<?php

namespace SebastiaanLuca\Preset;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;
use SebastiaanLuca\Preset\Presets\PackagePreset;
use SebastiaanLuca\Preset\Presets\Preset;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/preset-sebastiaanluca.php', 'preset-sebastiaanluca');

        PresetCommand::macro('sebastiaanluca', static function (PresetCommand $command) : void {
            Preset::install($command);
        });

        PresetCommand::macro('sebastiaanluca/package', static function (PresetCommand $command) : void {
            PackagePreset::install($command);
        });
    }
}
