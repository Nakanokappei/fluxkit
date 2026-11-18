{{-- The search field of a list. Standardizes the typing delay, clearing (the × in the field), type=search and aria-label.

        <x-fluxkit::search-input model="search" :label="$searchLabel"
            :placeholder="$searchPlaceholder" class="w-72" data-test="user-search" />

      model     The Livewire property that receives the typed text (wire:model.live.debounce)
      label     Accessible name (aria-label). Not shown on screen, since the field sits next to a heading
      debounce  Milliseconds between the last keystroke and sending. Default 400. On screens that log each
                search, changing it changes the number of log entries

    Clearing is the × in the field (clearable). class goes on a wrapping div, so width classes such as w-72 take
    effect (flux:input's own wrapper is w-full, which would win over a width passed to it). Without a width class
    the field is full width, as before. Other attributes (placeholder, size, data-test) go to flux:input.
    Do not use it for fields that search only when a button is pressed. --}}
@props(['model', 'label', 'debounce' => 400])

{{-- [:where(&)]:w-full has zero specificity, so any width class from the caller overrides it. --}}
<div {{ $attributes->only('class')->class('[:where(&)]:w-full') }}>
    <flux:input type="search" icon="magnifying-glass" clearable :aria-label="$label"
        :attributes="$attributes->except('class')->merge(['wire:model.live.debounce.'.$debounce.'ms' => $model])" />
</div>
