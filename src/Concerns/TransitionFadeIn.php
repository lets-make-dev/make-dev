<?php

namespace MakeDev\MakeDev\Concerns;

use MakeDev\MakeDev\Contracts\TransitionDefinition;
use MakeDev\MakeDev\Transitions\FadeIn;

trait TransitionFadeIn
{
    /** @return class-string<TransitionDefinition> */
    public static function transitionFadeInDefinition(): string
    {
        return FadeIn::class;
    }
}
