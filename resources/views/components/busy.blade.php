{{--
    An indicator shown while waiting for the server. On screens where filtering or paging takes a few seconds,
    it keeps the screen from looking frozen.

    Place it inside a Livewire component (wire:loading reacts only to requests of the component it is in).
    When a request takes longer than 200ms, it shows a sliding bar at the very top of the screen and
    "Loading…", and turns the mouse cursor into the wait cursor. It only toggles data-busy; the look is
    [data-ui-busy] in the package's resources/css/fluxkit.css.

        <div>
            <x-fluxkit::busy />
            …
        </div>
--}}
<div wire:loading.delay.attr="data-busy" data-ui-busy role="status" aria-live="polite"
    class="pointer-events-none fixed inset-x-0 top-0 z-50 flex-col items-center">
    <div class="h-1 w-full overflow-hidden bg-blue-100">
        <div class="ui-busy-bar h-full w-1/3 bg-blue-600"></div>
    </div>
    <div class="mt-3 flex items-center gap-2 rounded-full bg-zinc-800 px-3 py-1.5 text-xs text-white shadow-lg">
        <flux:icon.loading class="size-4" />
        {{ __('Loading…') }}
    </div>
</div>
