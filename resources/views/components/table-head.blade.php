{{--
    The table header row (thead). Standardizes background, text size and color.

        <x-fluxkit::table-head><tr>…</tr></x-fluxkit::table-head>

    Header contents, such as sort arrows, differ per screen and are passed as is (for sortable columns, use x-fluxkit::sortable-th).
--}}
<thead {{ $attributes->merge(['class' => 'bg-zinc-50 text-left text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400']) }}>
    {{ $slot }}
</thead>
