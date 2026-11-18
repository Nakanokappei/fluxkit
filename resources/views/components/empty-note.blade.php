{{--
    A short line shown when a list is empty, inside a frame (x-fluxkit::card) with p-4.

        <x-fluxkit::empty-note>{{ $emptyText }}</x-fluxkit::empty-note>

      bare  true omits the frame. Use it inside a table's frame (x-fluxkit::card), in place of the table

    For a large dashed frame that emphasizes "no data", use x-fluxkit::empty-state.
    Attributes passed (data-test, …) go on the outer element.
--}}
@props(['bare' => false])

@if ($bare)
    <div {{ $attributes->merge(['class' => 'p-4 text-sm text-zinc-500']) }}>
        {{ $slot }}
    </div>
@else
    <x-fluxkit::card :attributes="$attributes->merge(['class' => 'p-4 text-sm text-zinc-500'])">
        {{ $slot }}
    </x-fluxkit::card>
@endif
