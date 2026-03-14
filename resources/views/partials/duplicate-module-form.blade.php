<div x-data="{ duplicateOpen: false, dupName: '', dupDesc: '' }">
    {{-- Duplicate Module Button --}}
    <button
        type="button"
        x-show="!duplicateOpen"
        x-on:click="duplicateOpen = true"
        class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-zinc-700 px-3 py-1.5 text-xs font-medium text-zinc-200 transition hover:bg-zinc-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3.5">
            <path d="M5.5 3.5A1.5 1.5 0 0 1 7 2h5.5A1.5 1.5 0 0 1 14 3.5V9a1.5 1.5 0 0 1-1.5 1.5H7A1.5 1.5 0 0 1 5.5 9V3.5Z" />
            <path d="M3.5 5.5A1.5 1.5 0 0 0 2 7v5.5A1.5 1.5 0 0 0 3.5 14H9a1.5 1.5 0 0 0 1.5-1.5V7A1.5 1.5 0 0 0 9 5.5H3.5Z" />
        </svg>
        Duplicate Module
    </button>

    {{-- Inline Form --}}
    <div x-show="duplicateOpen" x-transition class="space-y-2">
        <div>
            <label class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">New Module Name</label>
            <input
                type="text"
                x-model="dupName"
                placeholder="e.g. InvoiceTracker"
                class="mt-0.5 w-full rounded bg-zinc-900 px-2 py-1.5 text-xs text-zinc-200 placeholder-zinc-600 outline-none ring-1 ring-zinc-700 focus:ring-blue-500"
            />
        </div>

        <div>
            <label class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">Description (optional)</label>
            <textarea
                x-model="dupDesc"
                rows="2"
                placeholder="What should this module do?"
                class="mt-0.5 w-full resize-none rounded bg-zinc-900 px-2 py-1.5 text-xs text-zinc-200 placeholder-zinc-600 outline-none ring-1 ring-zinc-700 focus:ring-blue-500"
            ></textarea>
        </div>

        <div class="flex gap-1.5">
            <button
                type="button"
                x-on:click="if (dupName.trim()) { Livewire.dispatch('orca:scaffold-module', { sourceModule: {{ Js::from($moduleData) }}, newModuleName: dupName.trim(), newModuleDescription: dupDesc.trim() }); duplicateOpen = false; dupName = ''; dupDesc = ''; {{ $closeAction }} }"
                :disabled="!dupName.trim()"
                class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-500 disabled:opacity-50 disabled:hover:bg-blue-600"
            >
                Scaffold
            </button>
            <button
                type="button"
                x-on:click="duplicateOpen = false; dupName = ''; dupDesc = ''"
                class="rounded-lg bg-zinc-700 px-3 py-1.5 text-xs font-medium text-zinc-300 transition hover:bg-zinc-600"
            >
                Cancel
            </button>
        </div>
    </div>
</div>
