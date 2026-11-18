{{--
    Preview listing every fluxkit component (GET /fluxkit-preview; config fluxkit.preview; development only).

    A screen for checking the look. It is not inside a Livewire component, so buttons such as wire:click do nothing.
    When adding a component, add it here too (a SKILL.md rule). The text here is read only by developers, so it is not translated.
--}}
@php
    $many = new \Illuminate\Pagination\LengthAwarePaginator(range(1, 10), 120, 10, 3, ['pageName' => 'demoPage']);
    $none = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, ['pageName' => 'emptyPage']);
    $sections = [
        'card', 'table (table-head, sortable-th, cell-sub, sub-row, empty-row, table-pager, page-nav)',
        'empty-note, empty-state', 'name-badge, required-badge', 'delete-button, row-select-button, sort-handle',
        'search-input', 'dashed-box', 'pane', 'admin-page', 'busy',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>fluxkit preview</title>
    @vite(config('fluxkit.preview.vite'))
    @fluxAppearance(['nonce' => Vite::cspNonce()])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-800">
<main class="mx-auto flex max-w-5xl flex-col gap-8 p-8" data-test="fluxkit-preview">
    <div class="flex flex-col gap-1">
        <flux:heading size="xl">fluxkit preview</flux:heading>
        <flux:text>All components ({{ count($sections) }} sections). Usage and props are in the package's SKILL.md. Buttons are for looks only and do nothing.</flux:text>
    </div>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">card</flux:heading>
        <x-fluxkit::card class="flex flex-col gap-2 p-4">
            <flux:heading>A box that owns only the frame</flux:heading>
            <flux:text>Pass inner padding and layout as class.</flux:text>
        </x-fluxkit::card>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">table</flux:heading>
        <x-fluxkit::card class="overflow-x-auto">
            <table class="w-full text-sm">
                <x-fluxkit::table-head>
                    <tr>
                        <x-fluxkit::sortable-th column="name" sort="name" direction="asc">Name</x-fluxkit::sortable-th>
                        <th class="px-3 py-2 font-medium">Email</th>
                        <th class="px-3 py-2 text-end font-medium">Count</th>
                    </tr>
                </x-fluxkit::table-head>
                <tbody>
                    <tr class="border-t border-neutral-100 align-top">
                        <td class="px-3 py-2">
                            <x-fluxkit::row-select-button action="select(1)" :selected="true">Taro Yamada</x-fluxkit::row-select-button>
                            <x-fluxkit::cell-sub>A note stacked under the name (cell-sub)</x-fluxkit::cell-sub>
                        </td>
                        <td class="px-3 py-2 wrap-anywhere">taro@example.com</td>
                        <td class="px-3 py-2 text-end tabular-nums">12</td>
                    </tr>
                    <x-fluxkit::sub-row :cols="3">
                        <x-fluxkit::delete-button action="delete(1)" confirm="Delete this item?" />
                    </x-fluxkit::sub-row>
                    <tr class="border-t border-neutral-100 align-top">
                        <td class="px-3 py-2">Hanako Suzuki</td>
                        <td class="px-3 py-2 wrap-anywhere">hanako@example.com</td>
                        <td class="px-3 py-2 text-end tabular-nums">3</td>
                    </tr>
                </tbody>
            </table>
            <x-fluxkit::table-pager :paginator="$many" per-page="perPage" />
        </x-fluxkit::card>
        <x-fluxkit::card class="overflow-x-auto">
            <table class="w-full text-sm">
                <x-fluxkit::table-head><tr><th class="px-3 py-2 font-medium">Name</th></tr></x-fluxkit::table-head>
                <tbody>
                    <x-fluxkit::empty-row :cols="1">The row shown when there are no rows (empty-row)</x-fluxkit::empty-row>
                </tbody>
            </table>
            <x-fluxkit::table-pager :paginator="$none" per-page="perPage" />
        </x-fluxkit::card>
        <div class="flex items-center gap-2">
            <flux:text>page-nav alone:</flux:text>
            <x-fluxkit::page-nav :paginator="$many" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">empty-note, empty-state</flux:heading>
        <x-fluxkit::empty-note>A short line shown when a list is empty (empty-note)</x-fluxkit::empty-note>
        <x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center">
            <flux:heading>Nothing here yet (empty-state)</flux:heading>
        </x-fluxkit::empty-state>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">name-badge, required-badge</flux:heading>
        <div class="flex flex-wrap items-center gap-2">
            <x-fluxkit::name-badge name="Sales" color="blue" />
            <x-fluxkit::name-badge name="A very long name is truncated by width and shown in full in title" color="green" />
            <label for="fluxkit-preview-required" class="text-sm">Code <x-fluxkit::required-badge /></label>
            <input id="fluxkit-preview-required" aria-required="true" class="rounded-md border border-zinc-200 px-2 py-1 text-sm" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">delete-button, row-select-button, sort-handle</flux:heading>
        <div class="flex flex-wrap items-center gap-3">
            <x-fluxkit::delete-button action="delete(1)" confirm="Delete this item?" />
            <x-fluxkit::delete-button action="delete(2)" size="sm" :danger="true" />
            <x-fluxkit::delete-button action="remove(3)" label="Remove" />
            <x-fluxkit::row-select-button action="select(2)">A name that opens details when clicked</x-fluxkit::row-select-button>
            <x-fluxkit::sort-handle name="Rule A" />
            <x-fluxkit::sort-handle name="Rule B" :wide="false" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">search-input</flux:heading>
        <x-fluxkit::search-input model="search" label="Search users" placeholder="Search by name or email" class="w-72" />
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">dashed-box</flux:heading>
        <x-fluxkit::dashed-box as="form" method="POST" wire:submit="add" class="flex flex-wrap items-end gap-2">
            <flux:input :label="'Name'" />
            <flux:button type="submit" variant="primary">Add</flux:button>
        </x-fluxkit::dashed-box>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">pane</flux:heading>
        <x-fluxkit::pane name="demo">
            <x-slot:header>
                <flux:text class="text-xs font-medium text-zinc-500">Pane title</flux:text>
                <flux:button size="xs" variant="ghost">Right-side button</flux:button>
            </x-slot:header>
            <div class="p-3 text-sm">Pane contents</div>
        </x-fluxkit::pane>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">admin-page</flux:heading>
        <x-fluxkit::card class="p-4">
            <x-fluxkit::admin-page icon="cog-6-tooth" title="System settings" heading="Screen heading" subheading="One line on what this screen configures">
                <x-fluxkit::empty-note>Body</x-fluxkit::empty-note>
            </x-fluxkit::admin-page>
        </x-fluxkit::card>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">busy</flux:heading>
        <flux:text>Appears at the very top of the screen only while a Livewire request takes longer than 200ms (not shown in this preview).</flux:text>
        <x-fluxkit::busy />
    </section>
</main>

@livewireScripts
@fluxScripts(['nonce' => Vite::cspNonce()])
</body>
</html>
