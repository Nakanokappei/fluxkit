{{--
    サーバーの処理を待っているあいだの印。絞り込みやページ送りに数秒かかる画面で、何も動かないように
    見えるのを防ぐ。

    Livewire のコンポーネントの中に置く (wire:loading は、置いたコンポーネントの要求にだけ反応する)。
    要求が 200ms を超えたら、画面のいちばん上に流れる帯と「読み込んでいます…」を出し、マウスカーソルを
    待ちの形にする。出し入れは data-busy の付け外しだけで、見え方はパッケージの resources/css/fluxkit.css の [data-ui-busy]。

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
        {{ __('読み込んでいます…') }}
    </div>
</div>
