<?php

namespace SebastiaanLuca\Preset\Presets;

class AuthPreset extends Preset
{
    /**
     * Run the preset.
     *
     * @return void
     */
    public function run() : void
    {
        $this->command->info('Project authentication successfully scaffolded!');
    }
}
