{{-- A dashed box around an "add" form or a bulk-action section.

        <x-fluxkit::dashed-box as="form" method="POST" wire:submit="addLabel" class="flex flex-wrap items-end gap-2">
            …
        </x-fluxkit::dashed-box>

      as  The box element (form, section, div). Defaults to div

    Pass the inner layout (flex, gap) as class. Other attributes (wire:submit, data-test) go on the box.
    **Write method="POST" when it is a form too** (so input never lands in the URL if submitted before JS runs). --}}
@props(['as' => 'div'])

<{{ $as }} {{ $attributes->merge(['class' => 'rounded-xl border border-dashed border-neutral-300 p-4 dark:border-neutral-600']) }}>
    {{ $slot }}
</{{ $as }}>
