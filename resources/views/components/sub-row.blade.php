{{--
    The second row when a table shows one item in two rows. Action buttons, long descriptions and check results
    span the full table width instead of becoming columns (columns would squeeze the name column). The divider
    line is drawn only on the first row, so the two rows read as one item.

        <tr class="border-t border-neutral-100 align-top" wire:key="user-{{ $user->id }}"> … first row … </tr>
        <x-fluxkit::sub-row :cols="5" wire:key="user-actions-{{ $user->id }}">
            … buttons …
        </x-fluxkit::sub-row>

      cols   Number of table columns (colspan)
      align  'end' aligns right (action buttons). Defaults to left

    Attributes (wire:key, class, data-test) go on the tr. Text size and color are up to the contents
    (for a description, <div class="text-xs text-zinc-500">). For a note stacked under a name inside a cell, use x-fluxkit::cell-sub.
--}}
@props(['cols', 'align' => 'start'])

<tr {{ $attributes }}>
    <td @class(['px-3 pt-1 pb-2', 'text-end' => $align === 'end']) colspan="{{ $cols }}">{{ $slot }}</td>
</tr>
