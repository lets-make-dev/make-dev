<?php

namespace MakeDev\MakeDev\Skills;

abstract class ModuleSkill
{
    abstract public function view(): string;

    public function priority(): int
    {
        return 50;
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
