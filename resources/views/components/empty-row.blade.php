{{--
    The single row shown when a table has no rows. A muted line spanning the full table width.

        @forelse ($rows as $row) … @empty
            <x-fluxkit::empty-row :cols="3">{{ $emptyText }}</x-fluxkit::empty-row>
        @endforelse

      cols  Number of table columns (colspan)

    To show only a line without a table, use x-fluxkit::empty-note.
--}}
@props(['cols'])

<tr>
    <td colspan="{{ $cols }}" class="px-3 py-4 text-zinc-500">{{ $slot }}</td>
</tr>
