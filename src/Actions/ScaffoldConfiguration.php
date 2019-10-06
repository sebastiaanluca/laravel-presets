<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\project_config;
use function SebastiaanLuca\Preset\project_stub_path;

class ScaffoldConfiguration extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        foreach (project_config('files') as $file) {
            $filesystem->makeDirectory($filesystem->dirname(base_path($file)), 0755, true, true);
            $filesystem->copy(project_stub_path($file), base_path($file));
        }
    }
}
