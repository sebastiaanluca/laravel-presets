<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;

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

        $filesystem->moveDirectory(base_path('app'), base_path('_app'));

        if (! $filesystem->isDirectory($directory = base_path('app'))) {
            $filesystem->makeDirectory($directory, 0755, true);
        }

        $filesystem->moveDirectory(base_path('_app'), base_path('app/Framework'));
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
                $filesystem->put(
                    $file->getPathname(),
                    str_replace('App\\', 'Framework\\', $file->getContents())
                );
            }
        }
    }
}
