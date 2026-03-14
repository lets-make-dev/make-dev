<?php

namespace MakeDev\MakeDev\Skills;

use Modules\ModuleLoader\Support\DynamicModuleResolver;

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
        return app(DynamicModuleResolver::class)->modules() !== [];
    }
}
