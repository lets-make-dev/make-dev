<?php

namespace MakeDev\MakeDev\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use MakeDev\MakeDev\Support\ModuleOptions;

class SkillsContainer extends Component
{
    public function __construct(
        public string $popoverPosition = 'below',
        public ?bool $enabled = null,
    ) {}

    public function shouldRender(): bool
    {
        if ($this->enabled !== null) {
            return $this->enabled;
        }

        return app(ModuleOptions::class)->showSkills();
    }

    public function render(): View
    {
        return view('makedev::components.skills-container');
    }
}
