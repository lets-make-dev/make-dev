<?php

namespace MakeDev\MakeDev\Contracts;

interface HasTransitions
{
    /** @return TransitionDefinition[] */
    public function transitions(): array;
}
