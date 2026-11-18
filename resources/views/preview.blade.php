{{--
    Preview of the fluxkit components (GET /fluxkit-preview; config fluxkit.preview; development only).

    Sample screens built only from Flux and fluxkit, so the components can be seen the way an app uses them.
    Tabs switch between screen patterns (?pattern=…); each pattern is a partial in resources/views/preview/.
    Every component appears in at least one pattern. The page is not inside a Livewire component, so buttons such as
    wire:click do nothing. When adding a component, add it to a pattern too (a SKILL.md rule).
    The sample text is read only by developers, so it is not translated.
--}}
@php
    // The tabs: query value => [tab label, one-line description shown under the tabs].
    $patterns = [
        'users' => ['Users', 'An admin screen: toolbar, invite form, sortable table with a details pane, and empty states.'],
        'inbox' => ['Inbox', 'Master–detail: click a row (or Tab + Enter) to open it in the pane on the right.'],
        'labels' => ['Labels', 'A settings list: an add form in a dashed box, drag to reorder, rename and delete per row.'],
        'logs' => ['Logs', 'A dashboard of two independent tables on one screen, each with its own page name.'],
        'first-run' => ['First run', 'What screens look like before there is any data.'],
    ];

    // Unknown or missing values fall back to the first tab.
    $current = array_key_exists(request('pattern'), $patterns) ? request('pattern') : array_key_first($patterns);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>fluxkit preview — {{ $patterns[$current][0] }}</title>
    @vite(config('fluxkit.preview.vite'))
    @fluxAppearance(['nonce' => Vite::cspNonce()])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-800">
<x-fluxkit::busy />

<main class="mx-auto flex max-w-6xl flex-col gap-6 p-8" data-test="fluxkit-preview">
    {{-- What this page is, and the tabs. Tabs are plain links, so they work without JS. --}}
    <div class="flex flex-col gap-3 rounded-lg bg-zinc-800 px-4 pt-3 text-sm text-zinc-100">
        <div class="flex flex-col gap-1">
            <span class="font-medium">fluxkit preview — sample screens</span>
            <span class="text-zinc-300">Built only from Flux and the 20 fluxkit components. Static: buttons do nothing. Usage and props are in the package's SKILL.md.</span>
        </div>
        <nav class="-mb-px flex flex-wrap gap-1" aria-label="Sample screens">
            @foreach ($patterns as $key => [$label])
                <a href="?pattern={{ $key }}" data-test="pattern-{{ $key }}"
                    @if ($key === $current) aria-current="page" @endif
                    @class([
                        'rounded-t-md px-3 py-2 font-medium',
                        'bg-zinc-50 text-zinc-800' => $key === $current,
                        'text-zinc-300 hover:bg-zinc-700 hover:text-white' => $key !== $current,
                    ])>{{ $label }}</a>
            @endforeach
        </nav>
    </div>

    <flux:text class="-mt-3">{{ $patterns[$current][1] }}</flux:text>

    @include('fluxkit::preview.'.$current)
</main>

@livewireScripts
@fluxScripts(['nonce' => Vite::cspNonce()])
</body>
</html>
