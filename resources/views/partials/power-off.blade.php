@if (class_exists(\Modules\ModuleLoader\Support\DynamicModuleResolver::class) && app(\Modules\ModuleLoader\Support\DynamicModuleResolver::class)->modules() !== [])
    <button
        x-on:click="Livewire.dispatch('module-loader:power-off')"
        class="flex h-10 w-10 items-center justify-center rounded-full bg-black/5 text-black/30 backdrop-blur-sm transition hover:bg-black/10 hover:text-black/80"
        title="Power off"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18.36 6.64a9 9 0 1 1-12.73 0" />
            <line x1="12" y1="2" x2="12" y2="12" />
        </svg>
    </button>
@endif
