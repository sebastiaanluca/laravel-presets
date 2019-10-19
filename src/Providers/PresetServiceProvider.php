<?php

namespace SebastiaanLuca\Preset\Providers;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;
use SebastiaanLuca\Preset\Presets\AuthPreset;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $presets = [
        'sebastiaanluca:auth' => AuthPreset::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        foreach ($this->presets as $name => $class) {
            PresetCommand::macro($name, static function (PresetCommand $command) use ($class) : void {
                call_user_func([$class, 'install'], $command);
            });
        }
    }
}
