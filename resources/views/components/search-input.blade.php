{{-- The search field of a list. Standardizes the typing delay, clearing (the × in the field), type=search and aria-label.

        <x-fluxkit::search-input model="search" :label="$searchLabel"
            :placeholder="$searchPlaceholder" class="w-72" data-test="user-search" />

      model     The Livewire property that receives the typed text (wire:model.live.debounce)
      label     Accessible name (aria-label). Not shown on screen, since the field sits next to a heading
      debounce  Milliseconds between the last keystroke and sending. Default 400. On screens that log each
                search, changing it changes the number of log entries

    Clearing is the × in the field (clearable). Other attributes (placeholder, size, class, data-test) go to flux:input.
    Do not use it for fields that search only when a button is pressed. --}}
@props(['model', 'label', 'debounce' => 400])

<flux:input type="search" icon="magnifying-glass" clearable :aria-label="$label"
    :attributes="$attributes->merge(['wire:model.live.debounce.'.$debounce.'ms' => $model])" />
