{{--
    行を押して右の詳細を開く表の、キーボードの入口。<tr wire:click="select(id)"> だけでは Tab で行に
    届かない (tr はフォーカスを受けない)。名前のセルの中身をこのボタンで包み、Tab で届いて Enter・Space で
    開けるようにする。

        <tr wire:click="select({{ $rule->id }})" …>
            <td class="px-3 py-2 font-medium">
                <x-fluxkit::row-select-button action="select({{ $rule->id }})" :selected="$isSelected">{{ $rule->name }}</x-fluxkit::row-select-button>
            </td>

      action    押したときの Livewire の呼び出し (tr の wire:click と同じもの)
      selected  いま開いている行か (aria-pressed で読み上げに伝える)

    **tr の wire:click は消さない** (マウスで行のどこを押しても開く今の使い方を残す)。ボタンは wire:click.stop で、
    tr の wire:click と 2 回呼ばない (行の中のほかのボタンも .stop にする)。
    押せない行は disabled を渡す (処理中の行など)。見た目は文字のまま (枠も背景も付けない。フォーカスの輪は
    ブラウザの既定)。中の並べ方は class で渡す。
--}}
@props(['action', 'selected' => false])

<button
    type="button"
    wire:click.stop="{{ $action }}"
    aria-pressed="{{ $selected ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'cursor-pointer text-start disabled:cursor-default']) }}
>{{ $slot }}</button>
