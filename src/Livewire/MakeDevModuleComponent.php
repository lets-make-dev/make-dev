<?php

namespace MakeDev\MakeDev\Livewire;

use Livewire\Component;
use MakeDev\MakeDev\Concerns\HasModuleInfo;
use MakeDev\MakeDev\Concerns\ResolvesTransitions;
use MakeDev\MakeDev\Contracts\HasTransitions;
use MakeDev\MakeDev\Contracts\MakeDevModule;

abstract class MakeDevModuleComponent extends Component implements HasTransitions, MakeDevModule
{
    use HasModuleInfo, ResolvesTransitions;

    /**
     * Overlay positioning mode for this component.
     *
     * - 'fixed'  — toolbar pinned to viewport corner (full-page modules)
     * - 'inline' — toolbar positioned inside the component's root element
     */
    public function overlayPosition(): string
    {
        return 'fixed';
    }
}
