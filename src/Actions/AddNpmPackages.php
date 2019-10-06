<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use function SebastiaanLuca\Preset\project_config;

class AddNpmPackages extends Action
{
    public function execute() : void
    {
        $this->updatePackages($dev = false);
        $this->updatePackages($dev = true);

        $this->call('yarn install');
    }

    /**
     * @param bool $dev
     */
    protected function updatePackages($dev = true) : void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev
            ? 'devDependencies'
            : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true, 512, JSON_THROW_ON_ERROR);

        $packages[$configurationKey] = project_config(sprintf('npm.%s', $configurationKey));

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }
}
