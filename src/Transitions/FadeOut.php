<?php

namespace MakeDev\MakeDev\Transitions;

use MakeDev\MakeDev\Contracts\TransitionDefinition;

class FadeOut implements TransitionDefinition
{
    public function name(): string
    {
        return 'fade-out';
    }

    public function durationMs(): int
    {
        return 600;
    }

    public function requiresStarField(): bool
    {
        return false;
    }

    public function config(): array
    {
        return [
            'easing' => 'ease-in-out',
        ];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'durationMs' => $this->durationMs(),
            'requiresStarField' => $this->requiresStarField(),
            'config' => $this->config(),
        ];
    }
}
