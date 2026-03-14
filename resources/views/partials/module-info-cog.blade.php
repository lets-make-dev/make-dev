@php
    $moduleInfo = $this->moduleInfo();
    $popoverPosition ??= 'below';
@endphp

<div
    x-data="{ moduleInfoOpen: false }"
    class="relative"
>
    <button
        x-on:click.stop="moduleInfoOpen = !moduleInfoOpen"
        class="rounded-lg p-1.5 text-zinc-500 transition hover:bg-zinc-800 hover:text-zinc-300"
        title="Module Info"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="moduleInfoOpen"
        x-on:click.outside="moduleInfoOpen = false"
        x-on:keydown.escape.window="moduleInfoOpen = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        @class([
            'absolute w-80 rounded-lg border border-zinc-700 bg-zinc-800 p-3 shadow-xl',
            'right-0' => $popoverPosition !== 'below-right',
            'left-0' => $popoverPosition === 'below-right',
            'mt-1' => in_array($popoverPosition, ['below', 'below-right']),
            'bottom-full mb-1' => $popoverPosition === 'above',
        ])
        style="display: none;"
    >
        {{-- Name + Version --}}
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-zinc-200">{{ $moduleInfo['name'] }}</span>
            <span class="rounded bg-zinc-700 px-1.5 py-0.5 text-[10px] font-medium text-zinc-400">v{{ $moduleInfo['version'] }}</span>
        </div>

        {{-- Description --}}
        <p class="mt-1 text-xs leading-relaxed text-zinc-400">{{ $moduleInfo['description'] }}</p>

        {{-- Capabilities --}}
        @if (! empty($moduleInfo['capabilities']))
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach ($moduleInfo['capabilities'] as $capability)
                    <span class="rounded-full bg-blue-500/10 px-2 py-0.5 text-[10px] font-medium text-blue-400">{{ $capability }}</span>
                @endforeach
            </div>
        @endif

        {{-- Key Files --}}
        @if (! empty($moduleInfo['keyFiles']))
            <div class="mt-2">
                <span class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">Key Files</span>
                <div class="mt-0.5 rounded bg-zinc-900 px-2 py-1.5">
                    @foreach ($moduleInfo['keyFiles'] as $file)
                        <div class="truncate font-mono text-[11px] text-zinc-300" title="{{ $file }}">{{ $file }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Dependencies --}}
        @if (! empty($moduleInfo['dependencies']))
            <div class="mt-2">
                <span class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">Dependencies</span>
                <div class="mt-0.5 flex flex-wrap gap-1">
                    @foreach ($moduleInfo['dependencies'] as $dep)
                        <span class="rounded bg-zinc-700 px-1.5 py-0.5 text-[10px] text-zinc-400">{{ $dep }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Agent README --}}
        @if ($moduleInfo['agentReadme'])
            <div x-data="{ expanded: false }" class="mt-2">
                <button
                    x-on:click="expanded = !expanded"
                    class="flex items-center gap-1 text-[10px] font-medium uppercase tracking-wider text-zinc-500 hover:text-zinc-300"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="size-3 transition-transform"
                        :class="expanded ? 'rotate-90' : ''"
                    >
                        <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    Agent README
                </button>
                <div
                    x-show="expanded"
                    x-collapse
                    class="mt-1 max-h-48 overflow-y-auto rounded bg-zinc-900 px-2 py-1.5 font-mono text-[11px] leading-relaxed text-zinc-300 whitespace-pre-wrap"
                >{{ $moduleInfo['agentReadme'] }}</div>
            </div>
        @endif

        {{-- Orca Actions --}}
        @if (class_exists(\MakeDev\Orca\Livewire\Launcher::class))
            <div class="mt-2 space-y-1.5 border-t border-zinc-700 pt-2">
                <button
                    type="button"
                    x-on:click="Livewire.dispatch('orca:chat-module', { moduleInfo: {{ Js::from($moduleInfo) }} }); moduleInfoOpen = false"
                    class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-zinc-700 px-3 py-1.5 text-xs font-medium text-zinc-200 transition hover:bg-zinc-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3.5">
                        <path d="M1 8.74c0 .983.713 1.825 1.69 1.943.764.092 1.534.164 2.31.216v2.351a.75.75 0 0 0 1.28.53l2.51-2.51c.182-.181.427-.29.687-.312A24 24 0 0 0 13.31 10.7C14.287 10.6 15 9.758 15 8.773V4.226c0-.985-.714-1.827-1.69-1.945A23.9 23.9 0 0 0 8 2c-1.787 0-3.538.133-5.31.281C1.714 2.4 1 3.241 1 4.226z" />
                    </svg>
                    Chat with Orca
                </button>

                @include('makedev::partials.duplicate-module-form', ['moduleData' => $moduleInfo, 'closeAction' => 'moduleInfoOpen = false'])
            </div>
        @endif
    </div>
</div>
