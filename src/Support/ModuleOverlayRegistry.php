<?php

namespace MakeDev\MakeDev\Support;

class ModuleOverlayRegistry
{
    /** @var ModuleOverlay[] */
    protected array $overlays = [];

    public function push(string $view, string $position = 'upper-right', string $placement = 'inside', array $props = []): self
    {
        $this->overlays[] = new ModuleOverlay($view, $position, $placement, $props);

        return $this;
    }

    /** @return ModuleOverlay[] */
    public function overlays(): array
    {
        return $this->overlays;
    }
}
