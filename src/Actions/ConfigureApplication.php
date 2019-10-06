<?php /** @noinspection ALL */

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;

class ConfigureApplication extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        $path = base_path('config/app.php');

        $replace = [
            '/\s+Framework\\\\Providers\\\\AppServiceProvider::class,/' => '',
            '/\s+Framework\\\\Providers\\\\AuthServiceProvider::class,/' => '',
            '/\s+\/\/ Framework\\\\Providers\\\\BroadcastServiceProvider::class,/' => '',
            '/\s+Framework\\\\Providers\\\\EventServiceProvider::class,/' => '',
            '/\s+Framework\\\\Providers\\\\RouteServiceProvider::class,/' => '',
            '/Package Service Providers.../' => 'Package service providers',
            '/Application Service Providers.../' => 'Application service providers',
        ];

        $config = $filesystem->get($path);

        $config = preg_replace(
            array_keys($replace),
            array_values($replace),
            $config
        );

        $filesystem->put($path, $config);
    }
}
