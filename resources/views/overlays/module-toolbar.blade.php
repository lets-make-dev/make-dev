@if (app(\MakeDev\MakeDev\Support\ModuleOptions::class)->showSkills())
    <div @class([
        'flex items-center gap-1 z-50',
        'fixed top-4 right-4' => ($overlayPosition ?? 'fixed') === 'fixed',
        'absolute top-2 right-2' => ($overlayPosition ?? 'fixed') === 'inline',
    ])>
        @include('makedev::partials.module-skills', ['popoverPosition' => 'below'])
        @include('makedev::partials.power-off')
    </div>
@endif
