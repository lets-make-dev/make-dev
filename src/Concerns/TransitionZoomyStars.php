<?php

namespace MakeDev\MakeDev\Concerns;

use MakeDev\MakeDev\Contracts\TransitionDefinition;
use MakeDev\MakeDev\Transitions\ZoomyStars;

trait TransitionZoomyStars
{
    /** @return class-string<TransitionDefinition> */
    public static function transitionZoomyStarsDefinition(): string
    {
        return ZoomyStars::class;
    }
}
