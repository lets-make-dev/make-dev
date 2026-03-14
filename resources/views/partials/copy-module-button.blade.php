@php
    $moduleInfo = $this->moduleInfo();
    $popoverPosition ??= 'below';
@endphp

<div
    x-data="{ copyOpen: false, newName: '', newDesc: '' }"
    class="relative"
>
    <button
        x-on:click.stop="copyOpen = !copyOpen"
        class="rounded-lg p-1.5 text-zinc-500 transition hover:bg-zinc-800 hover:text-zinc-300"
        title="Copy Module"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path d="M5.5 3.5A1.5 1.5 0 0 1 7 2h5.5A1.5 1.5 0 0 1 14 3.5V9a1.5 1.5 0 0 1-1.5 1.5H7A1.5 1.5 0 0 1 5.5 9V3.5Z" />
            <path d="M3.5 5.5A1.5 1.5 0 0 0 2 7v5.5A1.5 1.5 0 0 0 3.5 14H9a1.5 1.5 0 0 0 1.5-1.5V7A1.5 1.5 0 0 0 9 5.5H3.5Z" />
        </svg>
    </button>

    <div
        x-show="copyOpen"
        x-on:click.outside="copyOpen = false"
        x-on:keydown.escape.window="copyOpen = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        @class([
            'absolute w-72 rounded-lg border border-zinc-700 bg-zinc-800 p-3 shadow-xl',
            'right-0' => $popoverPosition !== 'below-right',
            'left-0' => $popoverPosition === 'below-right',
            'mt-1' => in_array($popoverPosition, ['below', 'below-right']),
            'bottom-full mb-1' => $popoverPosition === 'above',
        ])
        style="display: none;"
    >
        <p class="mb-2 text-xs font-semibold text-zinc-200">Copy {{ $moduleInfo['name'] }}</p>

        <div class="space-y-2">
            <div>
                <label class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">New Module Name</label>
                <input
                    type="text"
                    x-model="newName"
                    placeholder="e.g. InvoiceTracker"
                    class="mt-0.5 w-full rounded bg-zinc-900 px-2 py-1.5 text-xs text-zinc-200 placeholder-zinc-600 outline-none ring-1 ring-zinc-700 focus:ring-blue-500"
                />
            </div>

            <div>
                <label class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">Description (optional)</label>
                <textarea
                    x-model="newDesc"
                    rows="2"
                    placeholder="What should this module do?"
                    class="mt-0.5 w-full resize-none rounded bg-zinc-900 px-2 py-1.5 text-xs text-zinc-200 placeholder-zinc-600 outline-none ring-1 ring-zinc-700 focus:ring-blue-500"
                ></textarea>
            </div>

            <div class="flex gap-1.5">
                <button
                    type="button"
                    x-on:click="if (newName.trim()) { Livewire.dispatch('orca:scaffold-module-terminal', { sourceModule: {{ Js::from($moduleInfo) }}, newModuleName: newName.trim(), newModuleDescription: newDesc.trim() }); copyOpen = false; newName = ''; newDesc = ''; }"
                    :disabled="!newName.trim()"
                    class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-500 disabled:opacity-50 disabled:hover:bg-blue-600"
                >
                    Create
                </button>
                <button
                    type="button"
                    x-on:click="copyOpen = false; newName = ''; newDesc = ''"
                    class="rounded-lg bg-zinc-700 px-3 py-1.5 text-xs font-medium text-zinc-300 transition hover:bg-zinc-600"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
