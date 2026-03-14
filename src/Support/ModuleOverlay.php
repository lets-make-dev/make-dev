<?php

namespace MakeDev\MakeDev\Support;

class ModuleOverlay
{
    public function __construct(
        public string $view,
        public string $position = 'upper-right',
        public string $placement = 'inside',
        public array $props = [],
    ) {}
}
