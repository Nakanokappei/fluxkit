{{-- The "Delete" button on a list row. A ghost trash-can button with a confirmation message.

        <x-fluxkit::delete-button action="delete({{ $item->id }})"
            :confirm="$confirmText" />

      action   The Livewire call made on click (wire:click)
      confirm  The confirmation message shown before the call (wire:confirm). null calls without asking
               (when the screen shows why it refuses instead)
      size     xs (default) or sm. Match the "Edit" button on the same row
      label    The button text. Defaults to "Delete"
      danger   true for a red outline (heavy deletes, such as removing a whole file)

    Other attributes passed (aria-label, data-test) go on the button. --}}
@props(['action', 'confirm' => null, 'size' => 'xs', 'label' => null, 'danger' => false])

<flux:button size="{{ $size }}" :variant="$danger ? 'outline' : 'ghost'" icon="trash"
    :attributes="$attributes->merge(array_filter([
        'wire:click' => $action,
        'wire:confirm' => $confirm,
        'class' => $danger ? '!border-red-400 !text-red-600 hover:!bg-red-50 [&_[data-flux-icon]]:!text-red-600' : null,
    ], fn ($v) => $v !== null))">
    {{ $label ?? __('Delete') }}
</flux:button>
