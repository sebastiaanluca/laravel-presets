<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\handle_filesystem_errors;
use function SebastiaanLuca\Preset\project_stub_path;

class CleanUpObsoletes extends Action
{
    public function execute() : void
    {
        tap(new Filesystem, static function (Filesystem $filesystem) : void {
            handle_filesystem_errors($filesystem->deleteDirectory(base_path('node_modules')));
            handle_filesystem_errors($filesystem->delete(base_path('yarn.lock')));

            handle_filesystem_errors($filesystem->deleteDirectory(base_path('routes')));
            handle_filesystem_errors($filesystem->deleteDirectory(public_path('css')));
            handle_filesystem_errors($filesystem->deleteDirectory(public_path('js')));
            handle_filesystem_errors($filesystem->deleteDirectory(resource_path('css')));
            handle_filesystem_errors($filesystem->deleteDirectory(resource_path('js')));
            handle_filesystem_errors($filesystem->deleteDirectory(resource_path('sass')));

            handle_filesystem_errors($filesystem->delete(base_path('app/Http/Controllers/Controller.php')));
            handle_filesystem_errors($filesystem->delete(base_path('app/Providers/AppServiceProvider.php')));
            handle_filesystem_errors($filesystem->delete(base_path('app/Providers/AuthServiceProvider.php')));
            handle_filesystem_errors($filesystem->delete(base_path('app/Providers/BroadcastServiceProvider.php')));
            handle_filesystem_errors($filesystem->delete(base_path('app/Providers/EventServiceProvider.php')));
            handle_filesystem_errors($filesystem->delete(base_path('app/Providers/RouteServiceProvider.php')));

            handle_filesystem_errors($filesystem->delete(base_path('.styleci.yml')));
            handle_filesystem_errors($filesystem->delete(base_path('phpunit.xml')));

            handle_filesystem_errors($filesystem->delete(base_path('app/User.php')));

            foreach ($filesystem->files(project_stub_path()) as $file) {
                handle_filesystem_errors($filesystem->delete(base_path($file->getRelativePathname())));
            }
        });
    }
}
