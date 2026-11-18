{{-- Preview pattern "Labels": a settings list. An add form in a dashed box, rows reordered by dragging, rename and delete per row. --}}
@php
    // Sample data: labels in their display order.
    $labels = [
        ['id' => 1, 'name' => 'Bug', 'color' => 'red', 'note' => 'Something does not work as documented', 'uses' => 214],
        ['id' => 2, 'name' => 'Feature request', 'color' => 'blue', 'note' => 'Asks for something new', 'uses' => 96],
        ['id' => 3, 'name' => 'Billing and invoices for enterprise contracts', 'color' => 'amber', 'note' => 'Long names are truncated; hover to see the full name', 'uses' => 12],
        ['id' => 4, 'name' => 'Question', 'color' => 'green', 'note' => null, 'uses' => 0],
    ];
@endphp

<x-fluxkit::admin-page icon="tag" title="Settings" heading="Labels"
    subheading="Labels sort incoming requests. The order here is the order shown in menus.">

    {{-- Add form: a Flux field with its own badge, and a plain select with the fluxkit badge. --}}
    <x-fluxkit::dashed-box as="form" method="POST" wire:submit="addLabel" class="flex flex-wrap items-end gap-3">
        <flux:input label="Name" badge="Required" placeholder="e.g. Feedback" class="w-64" />
        <div class="flex flex-col gap-2">
            <label for="label-color" class="text-sm font-medium">Color <x-fluxkit::required-badge /></label>
            <select id="label-color" aria-required="true" class="h-10 w-36 rounded-lg border border-zinc-200 bg-white px-2 text-sm">
                <option>Blue</option>
                <option>Green</option>
                <option>Amber</option>
                <option>Red</option>
            </select>
        </div>
        <flux:button type="submit" variant="primary" icon="plus">Add label</flux:button>
    </x-fluxkit::dashed-box>

    {{-- The list: drag the grip to reorder; each row can be renamed or deleted. --}}
    <x-fluxkit::card class="overflow-x-auto">
        <table class="w-full text-sm">
            <x-fluxkit::table-head>
                <tr>
                    <th class="w-px px-3 py-2"><span class="sr-only">Order</span></th>
                    <th class="px-3 py-2 font-medium">Label</th>
                    <th class="w-px whitespace-nowrap px-3 py-2 text-end font-medium">In use</th>
                    <th class="w-px px-3 py-2"><span class="sr-only">Actions</span></th>
                </tr>
            </x-fluxkit::table-head>
            <tbody wire:sort="reorderLabels">
                @foreach ($labels as $label)
                    <tr wire:sort:item="{{ $label['id'] }}" class="border-t border-neutral-100 align-top">
                        <td class="px-3 py-2"><x-fluxkit::sort-handle :name="$label['name']" /></td>
                        <td class="px-3 py-2">
                            <x-fluxkit::name-badge :name="$label['name']" :color="$label['color']" />
                            @if ($label['note'])
                                <x-fluxkit::cell-sub>{{ $label['note'] }}</x-fluxkit::cell-sub>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-end tabular-nums text-zinc-500">{{ $label['uses'] }}</td>
                        <td class="px-3 py-2">
                            <div class="flex items-center justify-end gap-1">
                                <flux:button size="xs" variant="ghost" icon="pencil-square">Rename</flux:button>
                                {{-- A label in use cannot be deleted; the screen says why instead of asking. --}}
                                <x-fluxkit::delete-button action="deleteLabel({{ $label['id'] }})"
                                    :confirm="$label['uses'] === 0 ? 'Delete this label?' : null" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-fluxkit::card>

    <div class="flex flex-col gap-2">
        <flux:heading size="md">Archived labels</flux:heading>
        <x-fluxkit::empty-note>Archived labels appear here. There are none.</x-fluxkit::empty-note>
    </div>
</x-fluxkit::admin-page>
