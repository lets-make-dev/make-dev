<?php

namespace MakeDev\MakeDev\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use MakeDev\MakeDev\Livewire\MakeDevModuleComponent;
use MakeDev\MakeDev\Skills\CopyModuleButton;
use MakeDev\MakeDev\Skills\ModuleInfoCog;
use MakeDev\MakeDev\Support\ModuleOptions;
use MakeDev\MakeDev\Support\ModuleOverlayRegistry;
use MakeDev\MakeDev\Support\ModuleSkillRegistry;

use function Livewire\on;

class MakeDevServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleOptions::class);
        $this->app->singleton(ModuleSkillRegistry::class);
        $this->app->singleton(ModuleOverlayRegistry::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'makedev');

        Blade::componentNamespace('MakeDev\\MakeDev\\View\\Components', 'makedev');

        $this->registerSkills();
        $this->registerOverlays();
        $this->registerOverlayRenderHook();
    }

    protected function registerSkills(): void
    {
        $registry = app(ModuleSkillRegistry::class);

        $registry->register(CopyModuleButton::class);
        $registry->register(ModuleInfoCog::class);
    }

    protected function registerOverlays(): void
    {
        app(ModuleOverlayRegistry::class)->push(
            view: 'makedev::overlays.module-toolbar',
            position: 'upper-right',
            placement: 'inside',
        );
    }

    protected function registerOverlayRenderHook(): void
    {
        on('render', function ($component, $view, $data) {
            if (! $component instanceof MakeDevModuleComponent) {
                return null;
            }

            $overlayPosition = $component->overlayPosition();
            $registry = app(ModuleOverlayRegistry::class);
            $renderedOverlays = [];

            foreach ($registry->overlays() as $overlay) {
                $overlayHtml = view($overlay->view, array_merge($overlay->props, [
                    'overlayPosition' => $overlayPosition,
                ]))->render();

                if (trim($overlayHtml) !== '') {
                    $renderedOverlays[] = ['html' => $overlayHtml, 'placement' => $overlay->placement];
                }
            }

            if ($renderedOverlays === []) {
                return null;
            }

            $needsRelative = $overlayPosition === 'inline';
            $skillsActive = app(ModuleOptions::class)->showSkills();

            return function ($html) use ($renderedOverlays, $needsRelative, $skillsActive) {
                $classesToAdd = [];

                if ($needsRelative) {
                    $classesToAdd[] = 'relative';
                }

                if ($skillsActive) {
                    $classesToAdd[] = 'pointer-events-none';
                }

                if ($classesToAdd !== []) {
                    $classes = implode(' ', $classesToAdd);

                    $html = preg_replace(
                        '/^(<\w+\s[^>]*class=")/s',
                        '$1'.$classes.' ',
                        $html,
                        1,
                        $count,
                    );

                    if ($count === 0) {
                        $html = preg_replace('/^(<\w+)/s', '$1 class="'.$classes.'"', $html, 1);
                    }
                }

                foreach ($renderedOverlays as $overlay) {
                    if ($overlay['placement'] === 'inside') {
                        $lastClose = strrpos($html, '</');
                        if ($lastClose !== false) {
                            $html = substr($html, 0, $lastClose).$overlay['html']."\n".substr($html, $lastClose);
                        }
                    }
                }

                return $html;
            };
        });
    }
}
