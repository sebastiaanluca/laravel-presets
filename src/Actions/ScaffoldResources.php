<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\project_stub_path;

class ScaffoldResources extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        $filesystem->copyDirectory(project_stub_path('resources/js'), resource_path('js'));
        $filesystem->copyDirectory(project_stub_path('resources/css'), resource_path('css'));
    }
}
