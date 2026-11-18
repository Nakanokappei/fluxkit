{{--
    The keyboard entry point for tables where clicking a row opens its details on the right. With only
    <tr wire:click="select(id)">, Tab never reaches the row (tr does not take focus). Wrap the contents of the
    name cell in this button so Tab reaches it and Enter or Space opens it.

        <tr wire:click="select({{ $rule->id }})" …>
            <td class="px-3 py-2 font-medium">
                <x-fluxkit::row-select-button action="select({{ $rule->id }})" :selected="$isSelected">{{ $rule->name }}</x-fluxkit::row-select-button>
            </td>

      action    The Livewire call made on click (same as the tr's wire:click)
      selected  Whether this row is the one currently open (announced via aria-pressed)

    **Keep the tr's wire:click** (so clicking anywhere on the row with a mouse still opens it). The button uses
    wire:click.stop so it does not fire together with the tr's wire:click (make other buttons in the row .stop too).
    Pass disabled for rows that cannot be opened (rows being processed, etc.). It looks like plain text (no border,
    no background; the focus ring is the browser default). Pass the inner layout as class.
--}}
@props(['action', 'selected' => false])

<button
    type="button"
    wire:click.stop="{{ $action }}"
    aria-pressed="{{ $selected ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'cursor-pointer text-start disabled:cursor-default']) }}
>{{ $slot }}</button>
