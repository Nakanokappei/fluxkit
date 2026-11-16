{{--
    一覧が空のときの小さな一文。枠 (x-fluxkit::card) の中に p-4 で出す。

        <x-fluxkit::empty-note>{{ __('項目はまだありません。…') }}</x-fluxkit::empty-note>

      bare  true なら枠を付けない。表の枠 (x-fluxkit::card) の中で、表の代わりに出すときに使う

    破線の大きな枠で「データが無い」ことを見せるのは x-fluxkit::empty-state。
    渡した属性 (data-test など) は外側の要素に付く。
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
