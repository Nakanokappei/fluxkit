{{--
    A pane laid out on detail screens and the like. Owns the frame and a title bar (title on the left, buttons on the right).

        <x-fluxkit::pane name="chat">
            <x-slot:header>
                <flux:text class="text-xs font-medium text-zinc-500">{{ $paneTitle }}</flux:text>
            </x-slot:header>
            …
        </x-fluxkit::pane>

      name    Value of data-pane (a marker for tests and for reordering panes)
      header  Contents of the bar. Title on the left, buttons on the right (pushed to both ends)

    The passed class is appended after the frame classes (vertically stacked panes use flex flex-col).
--}}
@props(['name', 'header'])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200']) }} data-pane="{{ $name }}">
    <div class="flex items-center justify-between gap-2 border-b border-neutral-200 px-3 py-1.5">
        {{ $header }}
    </div>
    {{ $slot }}
</section>
