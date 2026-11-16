{{-- 列見出しで並べ替える表の見出しのセル。th と flux:table.sortable の組と aria-sort を 1 つにした。

        <x-fluxkit::sortable-th column="name" :sort="$sort" :direction="$direction">{{ __('氏名') }}</x-fluxkit::sortable-th>

      column     並べ替える列の名前。押すと Livewire の sort('<column>') を呼ぶ (同じ列をもう一度押すと逆順)
      sort       いま並べ替えている列
      direction  asc か desc

    渡した class は th に足す (狭い列なら w-px whitespace-nowrap)。 --}}
@props(['column', 'sort', 'direction'])

<th {{ $attributes->merge(['class' => 'group/sortable px-3 py-2 font-medium']) }}
    aria-sort="{{ $sort === $column ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}">
    <flux:table.sortable :sorted="$sort === $column" :direction="$direction"
        wire:click="sort('{{ $column }}')" data-test="sort-{{ $column }}">
        {{ $slot }}
    </flux:table.sortable>
</th>
