{{--
    表の 1 件を 2 段で見せるときの 2 段目の行。操作のボタン・長い説明・確認の結果を、列にせず表の幅
    いっぱいに敷く (列にすると名前の列が押し潰される)。区切りの線は 1 段目の行にだけ引き、2 段で 1 件に見せる。

        <tr class="border-t border-neutral-100 align-top" wire:key="user-{{ $user->id }}"> … 1 段目 … </tr>
        <x-fluxkit::sub-row :cols="5" wire:key="user-actions-{{ $user->id }}">
            … ボタン …
        </x-fluxkit::sub-row>

      cols   表の列の数 (colspan)
      align  'end' で右に寄せる (操作のボタン)。既定は左

    属性 (wire:key・class・data-test) は tr に付く。字の大きさや色は中身の側で決める
    (説明なら <div class="text-xs text-zinc-500">)。セルの中で名前の下に積む補足は x-fluxkit::cell-sub。
--}}
@props(['cols', 'align' => 'start'])

<tr {{ $attributes }}>
    <td @class(['px-3 pt-1 pb-2', 'text-end' => $align === 'end']) colspan="{{ $cols }}">{{ $slot }}</td>
</tr>
