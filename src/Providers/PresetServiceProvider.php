<?php

namespace SebastiaanLuca\Preset\Providers;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;
use SebastiaanLuca\Preset\Commands\GenerateOauthKeys;
use SebastiaanLuca\Preset\Presets\ApiPreset;
use SebastiaanLuca\Preset\Presets\AuthPreset;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $presets = [
        'sebastiaanluca:api' => ApiPreset::class,
        'sebastiaanluca:auth' => AuthPreset::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        parent::register();

        $this->commands(
            GenerateOauthKeys::class
        );
    }

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
