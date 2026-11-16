{{-- 一覧の行の「削除」ボタン。ゴーストのごみ箱のボタンに確認の文を添える。

        <x-fluxkit::delete-button action="delete({{ $item->id }})"
            :confirm="$confirmText" />

      action   押したときの Livewire の呼び出し (wire:click)
      confirm  押す前に出す確かめの文 (wire:confirm)。null なら確かめずに呼ぶ (断る理由を画面で出すとき)
      size     xs (既定) か sm。同じ行の「編集」と揃える
      label    ボタンの語。既定は「削除」
      danger   true なら赤枠 (ファイルごと消すなど、重い削除)

    渡したほかの属性 (aria-label・data-test) はボタンに付く。 --}}
@props(['action', 'confirm' => null, 'size' => 'xs', 'label' => null, 'danger' => false])

<flux:button size="{{ $size }}" :variant="$danger ? 'outline' : 'ghost'" icon="trash"
    :attributes="$attributes->merge(array_filter([
        'wire:click' => $action,
        'wire:confirm' => $confirm,
        'class' => $danger ? '!border-red-400 !text-red-600 hover:!bg-red-50 [&_[data-flux-icon]]:!text-red-600' : null,
    ], fn ($v) => $v !== null))">
    {{ $label ?? __('削除') }}
</flux:button>
