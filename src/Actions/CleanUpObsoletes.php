<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\project_config;

class CleanUpObsoletes extends Action
{
    public function execute() : void
    {
        tap(new Filesystem, static function (Filesystem $filesystem) : void {
            $filesystem->deleteDirectory(base_path('node_modules'));
            $filesystem->delete(base_path('yarn.lock'));

            $filesystem->deleteDirectory(base_path('routes'));
            $filesystem->deleteDirectory(public_path('css'));
            $filesystem->deleteDirectory(public_path('js'));
            $filesystem->deleteDirectory(resource_path('css'));
            $filesystem->deleteDirectory(resource_path('js'));
            $filesystem->deleteDirectory(resource_path('sass'));

            $filesystem->delete(base_path('app/Http/Controllers/Controller.php'));
            $filesystem->delete(base_path('app/Providers/AppServiceProvider.php'));
            $filesystem->delete(base_path('app/Providers/AuthServiceProvider.php'));
            $filesystem->delete(base_path('app/Providers/BroadcastServiceProvider.php'));
            $filesystem->delete(base_path('app/Providers/EventServiceProvider.php'));
            $filesystem->delete(base_path('app/Providers/RouteServiceProvider.php'));

            $filesystem->delete(base_path('.styleci.yml'));
            $filesystem->delete(base_path('phpunit.xml'));

            $filesystem->delete(base_path('app/User.php'));

            foreach (project_config('files') as $file) {
                $filesystem->delete(base_path($file));
            }
        });
    }
}
