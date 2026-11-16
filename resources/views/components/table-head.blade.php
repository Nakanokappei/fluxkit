{{--
    表の見出し行 (thead)。背景・字の大きさ・色を揃える。

        <x-fluxkit::table-head><tr>…</tr></x-fluxkit::table-head>

    並べ替えの矢印など、見出しの中身は画面ごとに違うのでそのまま渡す (並べ替える列は x-fluxkit::sortable-th)。
--}}
<thead {{ $attributes->merge(['class' => 'bg-zinc-50 text-left text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400']) }}>
    {{ $slot }}
</thead>
