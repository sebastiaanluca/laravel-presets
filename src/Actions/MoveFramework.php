<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;

class MoveFramework extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        $filesystem->moveDirectory(base_path('app'), base_path('_app'));

        if (! $filesystem->isDirectory($directory = base_path('app'))) {
            $filesystem->makeDirectory($directory, 0755, true);
        }

        $filesystem->moveDirectory(base_path('_app'), base_path('app/Framework'));
    }
}
