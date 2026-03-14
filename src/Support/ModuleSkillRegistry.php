<?php

namespace MakeDev\MakeDev\Support;

use InvalidArgumentException;
use MakeDev\MakeDev\Skills\ModuleSkill;
use ReflectionClass;

class ModuleSkillRegistry
{
    /** @var array<int, class-string<ModuleSkill>> */
    protected array $skills = [];

    /**
     * Register a skill class.
     *
     * @param  class-string<ModuleSkill>  $skillClass
     */
    public function register(string $skillClass): void
    {
        $reflection = new ReflectionClass($skillClass);

        if (! $reflection->isSubclassOf(ModuleSkill::class)) {
            throw new InvalidArgumentException(
                "Class [{$skillClass}] must extend [".ModuleSkill::class.'].'
            );
        }

        $this->skills[] = $skillClass;
    }

    /**
     * Resolve enabled skills sorted by priority.
     *
     * @return array<int, ModuleSkill>
     */
    public function resolve(): array
    {
        $instances = [];

        foreach ($this->skills as $skillClass) {
            $skill = app($skillClass);

            if ($skill->isEnabled()) {
                $instances[] = $skill;
            }
        }

        usort($instances, fn (ModuleSkill $a, ModuleSkill $b) => $a->priority() <=> $b->priority());

        return $instances;
    }
}
