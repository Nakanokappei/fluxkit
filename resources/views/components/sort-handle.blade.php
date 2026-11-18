{{--
    The grip for rows reordered by dragging (Livewire's wire:sort:handle). The row (wire:sort:item) and the
    reorder call (wire:sort) belong to the caller.

        <x-fluxkit::sort-handle :name="$rule->name" />

      name  The name inserted into the accessible label "Drag :name to reorder"
      wide  true (default) for width w-10, false for w-8 (tight tables)

    data-test defaults to drag-handle (passing one replaces it). No dark: variants.
--}}
@props(['name', 'wide' => true])

<div wire:sort:handle
    {{ $attributes->merge(['data-test' => 'drag-handle'])->class([
        'flex h-8 cursor-grab items-center justify-center rounded-md border border-neutral-200 bg-zinc-50 text-zinc-500 hover:border-neutral-300 hover:bg-zinc-100 hover:text-zinc-800 active:cursor-grabbing',
        'w-10' => $wide,
        'w-8' => ! $wide,
    ]) }}
    title="{{ __('Drag to reorder') }}"
    aria-label="{{ __('Drag :name to reorder', ['name' => $name]) }}">
    <x-fluxkit::icon.grip-vertical variant="mini" />
</div>
