<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use function SebastiaanLuca\Preset\project_config;

class AddComposerPackages extends Action
{
    public function execute() : void
    {
        $packages = collect(project_config('composer.require'))
            ->map(static function ($value, $key) : string {
                return is_string($key)
                    ? $key . '=' . $value
                    : $value;
            })
            ->join(' ');

        $devPackages = collect(project_config('composer.require-dev'))
            ->map(static function ($value, $key) : string {
                return is_string($key)
                    ? $key . '=' . $value
                    : $value;
            })
            ->join(' ');

        $this->call('composer require --no-scripts ' . $packages);
        $this->call('composer require --no-scripts ' . $devPackages);

        $this->call('composer dumpautoload');
    }
}
