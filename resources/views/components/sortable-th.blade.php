{{-- A header cell for tables sorted by column header. Combines th, flux:table.sortable and aria-sort into one.

        <x-fluxkit::sortable-th column="name" :sort="$sort" :direction="$direction">{{ $nameLabel }}</x-fluxkit::sortable-th>

      column     The column name to sort by. Clicking calls Livewire's sort('<column>') (clicking the same column again reverses)
      sort       The column currently sorted by
      direction  asc or desc

    The passed class is added to th (narrow columns: w-px whitespace-nowrap). --}}
@props(['column', 'sort', 'direction'])

<th {{ $attributes->merge(['class' => 'group/sortable px-3 py-2 font-medium']) }}
    aria-sort="{{ $sort === $column ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}">
    <flux:table.sortable :sorted="$sort === $column" :direction="$direction"
        wire:click="sort('{{ $column }}')" data-test="sort-{{ $column }}">
        {{ $slot }}
    </flux:table.sortable>
</th>
