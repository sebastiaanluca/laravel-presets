<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Support\Arr;
use function SebastiaanLuca\Preset\project_config;

class ConfigureComposer extends Action
{
    public function execute() : void
    {
        $composerPath = base_path('composer.json');

        if (! file_exists($composerPath)) {
            $this->command->warn('composer.json not found, skipping configuration.');

            return;
        }

        $config = json_decode(
            file_get_contents($composerPath),
            true,
            512,
            JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY | JSON_UNESCAPED_SLASHES
        );

        Arr::set($config, 'autoload.psr-4', [
            'Domain\\' => 'app/Domain/',
            'Framework\\' => 'app/Framework/',
            'Interfaces\\' => 'app/Interfaces/',
            'Modules\\' => 'app/Modules/',
        ]);

        Arr::set($config, 'extra', project_config('composer.extra'));
        Arr::set($config, 'scripts', project_config('composer.scripts'));

        $config = json_encode(
            $config,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        file_put_contents($composerPath, $config . PHP_EOL);

        $this->call('composer update nothing');
        $this->call('composer validate --no-check-all --strict');
    }
}
