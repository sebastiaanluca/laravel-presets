<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\handle_filesystem_errors;

class MoveFramework extends Action
{
    public function execute() : void
    {
        $this->move();
        $this->update();
    }

    protected function move() : void
    {
        $filesystem = new Filesystem;

        handle_filesystem_errors($filesystem->moveDirectory(base_path('app'), base_path('_app')));

        if (! $filesystem->isDirectory($directory = base_path('app'))) {
            handle_filesystem_errors($filesystem->makeDirectory($directory, 0755, true));
        }

        handle_filesystem_errors($filesystem->moveDirectory(base_path('_app'), base_path('app/Framework')));
    }

    protected function update() : void
    {
        $filesystem = new Filesystem;

        $paths = [
            'app/Framework',
            'bootstrap',
            'config',
        ];

        foreach ($paths as $path) {
            foreach ($filesystem->allFiles(base_path($path)) as $file) {
                handle_filesystem_errors(
                    (bool) $filesystem->put(
                        $file->getPathname(),
                        str_replace('App\\', 'Framework\\', $file->getContents())
                    )
                );
            }
        }
    }
}
