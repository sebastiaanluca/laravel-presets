<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Actions;

class RemovePresetPackage extends Action
{
    public function execute() : void
    {
        $this->call('composer remove sebastiaanluca/laravel-preset');
    }
}
