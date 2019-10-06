<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

use Illuminate\Filesystem\Filesystem;
use function SebastiaanLuca\Preset\add_gitkeep_to;

class ScaffoldApplication extends Action
{
    public function execute() : void
    {
        $filesystem = new Filesystem;

        $filesystem->makeDirectory(base_path('app/Domain'), 0755, true);
        $filesystem->makeDirectory(base_path('app/Interfaces/Web'), 0755, true);
        $filesystem->makeDirectory(base_path('app/Modules'), 0755, true);

        add_gitkeep_to(base_path('app/Domain'));
        add_gitkeep_to(base_path('app/Interfaces/Web'));
        add_gitkeep_to(base_path('app/Modules'));
    }
}
