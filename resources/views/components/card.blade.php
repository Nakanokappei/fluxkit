{{--
    画面の中の「箱」。一覧・表・フォームを囲む。

    **持つのは枠だけ** — 角丸・枠線・背景（ダークモードを含む）。中の余白と
    並べ方は画面ごとに違うので、使う側が class で渡す。

        <x-fluxkit::card class="flex flex-col gap-3 p-4">…</x-fluxkit::card>

    渡した class は枠のうしろに足される。Tailwind は並び順を見ないので、
    書き方を変えても見え方は変わらない。
--}}
<div {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900']) }}>
    {{ $slot }}
</div>
