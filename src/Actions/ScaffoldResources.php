<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use function SebastiaanLuca\Preset\handle_filesystem_errors;
use function SebastiaanLuca\Preset\project_config;
use function SebastiaanLuca\Preset\project_stub_path;

class ScaffoldResources extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        foreach (project_config('files') as $file) {
            handle_filesystem_errors($filesystem->makeDirectory($filesystem->dirname(base_path($file)), 0755, true, true));

            if (! Str::contains($file, '.')) {
                handle_filesystem_errors($filesystem->copyDirectory(project_stub_path($file), base_path($file)));
            } else {
                handle_filesystem_errors($filesystem->copy(project_stub_path($file), base_path($file)));
            }
        }
    }
}
