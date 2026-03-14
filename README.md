<pre align="center">
                                                       
██▄  ▄██ ▄████▄ ██ ▄█▀ ██████     ████▄  ██████ ██  ██ 
██ ▀▀ ██ ██▄▄██ ████   ██▄▄   ▄▄▄ ██  ██ ██▄▄   ██▄▄██ 
██    ██ ██  ██ ██ ▀█▄ ██▄▄▄▄     ████▀  ██▄▄▄▄  ▀██▀  

</pre>

<p align="center">
The base framework for building modular Laravel applications with transitions, skills, overlays, and AI-ready module metadata.
</p>

<p align="center">

[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire 4](https://img.shields.io/badge/Livewire-4-FB70A9?logo=livewire&logoColor=white)](https://livewire.laravel.com)

</p>

## What is MakeDev?

MakeDev provides the foundation for a module-based development ecosystem. It gives you an abstract Livewire component base class, a transition/animation system, a skills toolbar, and an overlay system — everything you need to build self-contained, metadata-rich modules that integrate with AI tools like [Orca](../Orca).

## Quick Start

```bash
composer require make-dev/makedev
```

That's it. The service provider auto-registers via Composer's package discovery.

## Features

- **MakeDevModuleComponent** — Abstract Livewire base class for modules. Provides structured metadata, transition support, and overlay integration out of the box.

- **Transition System** — Pre-built entry/exit animations (FadeIn, FadeOut, ZoomyStars) with an extensible `TransitionDefinition` interface for custom transitions.

- **Skills Toolbar** — Contextual UI buttons that appear on modules: info cog (metadata viewer), copy module (duplication scaffolding), and power off. Skills are priority-sorted and conditionally enabled at runtime.

- **Overlay System** — Floating toolbars rendered on module components with configurable positioning (fixed or inline) and placement (inside or outside).

- **Module Metadata** — Structured `moduleInfo()` arrays with name, description, version, key files, capabilities, dependencies, and Agent README support for AI context.

## Creating a Module

Extend `MakeDevModuleComponent` and implement `moduleInfo()`:

```php
namespace Modules\MyModule\Livewire;

use MakeDev\MakeDev\Livewire\MakeDevModuleComponent;
use MakeDev\MakeDev\Concerns\TransitionFadeIn;
use MakeDev\MakeDev\Concerns\TransitionFadeOut;

class MyModule extends MakeDevModuleComponent
{
    use TransitionFadeIn, TransitionFadeOut;

    public function moduleInfo(): array
    {
        return [
            'name' => 'My Module',
            'description' => 'Does something cool.',
            'version' => '1.0.0',
            'keyFiles' => [
                'Modules/MyModule/app/Livewire/MyModule.php',
            ],
            'capabilities' => ['Feature A', 'Feature B'],
            'dependencies' => ['livewire/livewire'],
            'agentReadme' => $this->loadAgentReadme(),
        ];
    }

    public function render()
    {
        return view('mymodule::livewire.my-module');
    }
}
```

Visit any page with `?mo=skills` to reveal the module toolbar.

## Transitions

Three built-in transitions are available as convenience traits:

| Trait | Effect | Duration |
|---|---|---|
| `TransitionFadeIn` | Opacity fade in | 600ms |
| `TransitionFadeOut` | Opacity fade out | 600ms |
| `TransitionZoomyStars` | Star field zoom acceleration | 1800ms |

Add transitions by using the traits on your component:

```php
use TransitionFadeIn, TransitionFadeOut;
```

Create custom transitions by implementing `TransitionDefinition`:

```php
use MakeDev\MakeDev\Contracts\TransitionDefinition;

class SlideIn implements TransitionDefinition
{
    public function name(): string { return 'slide-in'; }
    public function durationMs(): int { return 400; }
    public function requiresStarField(): bool { return false; }
    public function config(): array { return ['direction' => 'left']; }
    public function toArray(): array { /* ... */ }
}
```

## Skills

Skills are contextual action buttons rendered in the module toolbar overlay.

### Built-in Skills

| Skill | Description | Conditional |
|---|---|---|
| **ModuleInfoCog** | Displays module metadata (name, version, capabilities, Agent README) | Always available |
| **CopyModuleButton** | Duplication/scaffolding interface | Requires Orca |
| **PowerOff** | Module shutdown button | Requires ModuleLoader |

### Module Options

Control skill visibility with query parameters or session flags:

```
https://myapp.test/dashboard?mo=skills
```

The `ModuleOptions` singleton provides programmatic access:

```php
app(ModuleOptions::class)->showSkills();   // bool
app(ModuleOptions::class)->hasFlag('skills'); // bool
```

## Architecture

```
src/
├── Concerns/               # Traits (HasModuleInfo, ResolvesTransitions, Transition*)
├── Contracts/              # Interfaces (MakeDevModule, HasTransitions, TransitionDefinition)
├── Livewire/
│   └── MakeDevModuleComponent.php   # Abstract base component
├── Skills/                 # ModuleSkill base, CopyModuleButton, ModuleInfoCog, PowerOff
├── Support/                # ModuleOptions, ModuleOverlay, registries
├── Transitions/            # FadeIn, FadeOut, ZoomyStars
├── View/Components/        # SkillsContainer blade component
└── Providers/
    └── MakeDevServiceProvider.php
```

### Service Provider Registration

The `MakeDevServiceProvider` registers:
- `ModuleOptions`, `ModuleSkillRegistry`, `ModuleOverlayRegistry` as singletons
- Views under the `makedev::` namespace
- Blade components under the `makedev::` prefix
- Default skills (ModuleInfoCog, CopyModuleButton)
- Default overlay (module-toolbar)
- Livewire render hook for overlay injection

## Integration

MakeDev integrates with the broader MakeDev ecosystem:

- **[Orca](../Orca)** — When available, enables the Copy Module skill with Claude-powered scaffolding
- **[OrcaHarpoon](../OrcaHarpoon)** — Generated components extend `MakeDevModuleComponent` with full metadata
- **ModuleLoader** — When available, enables the Power Off skill for module lifecycle management

## License

MIT
