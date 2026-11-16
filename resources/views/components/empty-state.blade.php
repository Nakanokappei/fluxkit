{{--
    「まだ何もありません」の破線の箱。データが無いことを大きく見せる。

    **持つのは破線の枠と中央寄せだけ。** 余白と枠の濃さは画面ごとに違う
    （データが無いことを大きく見せる画面と、小さく添える画面がある）ので、
    使う側が class で渡す。

        <x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center dark:bg-zinc-900">…</x-fluxkit::empty-state>
--}}
<div {{ $attributes->merge(['class' => 'flex flex-1 flex-col items-center justify-center gap-3 rounded-xl border border-dashed dark:border-neutral-700']) }}>
    {{ $slot }}
</div>
