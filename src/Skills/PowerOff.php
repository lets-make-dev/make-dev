<?php

namespace MakeDev\MakeDev\Skills;

class PowerOff extends ModuleSkill
{
    public function view(): string
    {
        return 'makedev::partials.power-off';
    }

    public function priority(): int
    {
        return 99;
    }

    public function isEnabled(): bool
    {
        if (! class_exists(\Modules\ModuleLoader\Support\DynamicModuleResolver::class)) {
            return false;
        }

        return app(\Modules\ModuleLoader\Support\DynamicModuleResolver::class)->modules() !== [];
    }
}
