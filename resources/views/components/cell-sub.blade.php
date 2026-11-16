{{--
    表のセルの中で、名前などの下に積む補足の 1 行。列を増やすと名前の列が押し潰されるので、種類・ID・
    保存した日時のような添え書きは列にせず、セルの中で下に積む。

        <td class="px-3 py-2">
            {{ $connection->name }}
            <x-fluxkit::cell-sub>{{ $connection->target() }}</x-fluxkit::cell-sub>
        </td>

    属性 (class・data-test など) は div に付く (font-mono・tabular-nums・wrap-anywhere を足すとき)。
    表の幅いっぱいに敷く 2 段目の行は x-fluxkit::sub-row。
--}}
<div {{ $attributes->class('mt-0.5 text-xs text-zinc-500') }}>{{ $slot }}</div>
