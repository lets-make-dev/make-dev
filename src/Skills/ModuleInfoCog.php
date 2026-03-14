<?php

namespace MakeDev\MakeDev\Skills;

class ModuleInfoCog extends ModuleSkill
{
    public function view(): string
    {
        return 'makedev::partials.module-info-cog';
    }

    public function priority(): int
    {
        return 20;
    }
}
