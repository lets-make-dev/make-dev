<?php

namespace MakeDev\MakeDev\Transitions;

use MakeDev\MakeDev\Contracts\TransitionDefinition;

class ZoomyStars implements TransitionDefinition
{
    public function name(): string
    {
        return 'zoomy-stars';
    }

    public function durationMs(): int
    {
        return 1800;
    }

    public function requiresStarField(): bool
    {
        return true;
    }

    public function config(): array
    {
        return [
            'accelerationFactor' => 6.0,
            'sizeGrowFactor' => 5.0,
            'streakLength' => 8,
            'fadeToColor' => [3, 13, 26],
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
