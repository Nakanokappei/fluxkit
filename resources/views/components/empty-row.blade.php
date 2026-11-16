{{--
    表に行が無いときの 1 行。表の幅いっぱいに、薄い色の一文を出す。

        @forelse ($rows as $row) … @empty
            <x-fluxkit::empty-row :cols="3">{{ __('この期間のエラーはありません。') }}</x-fluxkit::empty-row>
        @endforelse

      cols  表の列の数 (colspan)

    表を出さずに一文だけ出すときは x-fluxkit::empty-note。
--}}
@props(['cols'])

<tr>
    <td colspan="{{ $cols }}" class="px-3 py-4 text-zinc-500">{{ $slot }}</td>
</tr>
