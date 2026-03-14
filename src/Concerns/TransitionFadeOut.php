<?php

namespace MakeDev\MakeDev\Concerns;

use MakeDev\MakeDev\Contracts\TransitionDefinition;
use MakeDev\MakeDev\Transitions\FadeOut;

trait TransitionFadeOut
{
    /** @return class-string<TransitionDefinition> */
    public static function transitionFadeOutDefinition(): string
    {
        return FadeOut::class;
    }
}
