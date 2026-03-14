<?php

namespace MakeDev\MakeDev\Contracts;

interface TransitionDefinition
{
    public function name(): string;

    public function durationMs(): int;

    public function requiresStarField(): bool;

    /** @return array<string, mixed> */
    public function config(): array;

    /** @return array<string, mixed> */
    public function toArray(): array;
}
