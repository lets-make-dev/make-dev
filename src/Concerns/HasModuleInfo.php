<?php

namespace MakeDev\MakeDev\Concerns;

use MakeDev\MakeDev\Support\ModuleOptions;

trait HasModuleInfo
{
    public bool $moduleInfoEnabled = false;

    public function mountHasModuleInfo(): void
    {
        $this->moduleInfoEnabled = app(ModuleOptions::class)->showSkills();
    }

    public function isModuleInfoEnabled(): bool
    {
        return $this->moduleInfoEnabled;
    }

    /**
     * Walk up from the class file to find the module/package root (contains module.json or composer.json).
     */
    public function moduleBasePath(): ?string
    {
        $reflection = new \ReflectionClass(static::class);
        $dir = dirname($reflection->getFileName());

        $maxDepth = 10;

        while ($dir !== '/' && $maxDepth-- > 0) {
            if (file_exists($dir.'/module.json') || file_exists($dir.'/composer.json')) {
                return $dir;
            }
            $dir = dirname($dir);
        }

        return null;
    }

    public function loadAgentReadme(): ?string
    {
        $basePath = $this->moduleBasePath();

        if (! $basePath) {
            return null;
        }

        $readmePath = $basePath.'/AGENT_README.md';

        if (! file_exists($readmePath)) {
            return null;
        }

        return file_get_contents($readmePath);
    }

    /**
     * @return array<string, mixed>
     */
    public function loadModuleJson(): array
    {
        $basePath = $this->moduleBasePath();

        if (! $basePath || ! file_exists($basePath.'/module.json')) {
            return [];
        }

        $contents = file_get_contents($basePath.'/module.json');

        return json_decode($contents, true) ?: [];
    }
}
