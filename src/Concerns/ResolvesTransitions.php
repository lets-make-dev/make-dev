<?php

namespace MakeDev\MakeDev\Concerns;

use MakeDev\MakeDev\Contracts\TransitionDefinition;
use ReflectionClass;

trait ResolvesTransitions
{
    /** @return TransitionDefinition[] */
    public function transitions(): array
    {
        return static::resolvedTransitions();
    }

    /** @return TransitionDefinition[] */
    public static function resolvedTransitions(): array
    {
        $transitions = [];

        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getMethods() as $method) {
            if (! $method->isStatic()) {
                continue;
            }

            if (! str_starts_with($method->getName(), 'transition') || ! str_ends_with($method->getName(), 'Definition')) {
                continue;
            }

            $class = $method->invoke(null);

            if (is_string($class) && class_exists($class) && is_subclass_of($class, TransitionDefinition::class)) {
                $transitions[] = new $class;
            }
        }

        return $transitions;
    }
}
