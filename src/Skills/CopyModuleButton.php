<?php

namespace MakeDev\MakeDev\Skills;

use MakeDev\Orca\Livewire\Launcher;

class CopyModuleButton extends ModuleSkill
{
    public function view(): string
    {
        return 'makedev::partials.copy-module-button';
    }

    public function priority(): int
    {
        return 10;
    }

    public function isEnabled(): bool
    {
        return class_exists(Launcher::class);
    }
}
