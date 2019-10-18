<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\handle_filesystem_errors;
use function SebastiaanLuca\Preset\project_stub_path;

class ScaffoldResources extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        handle_filesystem_errors(
            $filesystem->copyDirectory(project_stub_path(), base_path())
        );
    }
}
