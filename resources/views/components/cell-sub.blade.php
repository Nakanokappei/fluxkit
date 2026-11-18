{{--
    A supplementary line stacked under a name inside a table cell. Adding columns squeezes the name column,
    so side notes such as a type, an ID or a saved-at time are stacked inside the cell instead of becoming columns.

        <td class="px-3 py-2">
            {{ $connection->name }}
            <x-fluxkit::cell-sub>{{ $connection->target() }}</x-fluxkit::cell-sub>
        </td>

    Attributes (class, data-test, …) go on the div (e.g. to add font-mono, tabular-nums, wrap-anywhere).
    For a second row spanning the full table width, use x-fluxkit::sub-row.
--}}
<div {{ $attributes->class('mt-0.5 text-xs text-zinc-500') }}>{{ $slot }}</div>
