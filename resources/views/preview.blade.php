{{--
    fluxkit の部品を全部並べたプレビュー (GET /fluxkit-preview。config fluxkit.preview。開発環境だけ)。

    見た目を確かめるための画面で、Livewire のコンポーネントの中ではないので、wire:click などのボタンは押しても動かない。
    部品を足したら、ここにも足す (SKILL.md の決まり)。画面の文は開発者だけが読むので訳さない。
--}}
@php
    $many = new \Illuminate\Pagination\LengthAwarePaginator(range(1, 10), 120, 10, 3, ['pageName' => 'demoPage']);
    $none = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, ['pageName' => 'emptyPage']);
    $sections = [
        'card', 'table (table-head・sortable-th・cell-sub・sub-row・empty-row・table-pager・page-nav)',
        'empty-note・empty-state', 'name-badge・required-badge', 'delete-button・row-select-button・sort-handle',
        'search-input', 'dashed-box', 'pane', 'admin-page', 'busy',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>fluxkit preview</title>
    @vite(config('fluxkit.preview.vite'))
    @fluxAppearance(['nonce' => Vite::cspNonce()])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-800">
<main class="mx-auto flex max-w-5xl flex-col gap-8 p-8" data-test="fluxkit-preview">
    <div class="flex flex-col gap-1">
        <flux:heading size="xl">fluxkit preview</flux:heading>
        <flux:text>部品の一覧 ({{ count($sections) }} 節)。使い方と props はパッケージの SKILL.md。ボタンは見た目だけで動かない。</flux:text>
    </div>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">card</flux:heading>
        <x-fluxkit::card class="flex flex-col gap-2 p-4">
            <flux:heading>枠だけを持つ箱</flux:heading>
            <flux:text>中の余白と並べ方は class で渡す。</flux:text>
        </x-fluxkit::card>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">table</flux:heading>
        <x-fluxkit::card class="overflow-x-auto">
            <table class="w-full text-sm">
                <x-fluxkit::table-head>
                    <tr>
                        <x-fluxkit::sortable-th column="name" sort="name" direction="asc">名前</x-fluxkit::sortable-th>
                        <th class="px-3 py-2 font-medium">メールアドレス</th>
                        <th class="px-3 py-2 text-end font-medium">件数</th>
                    </tr>
                </x-fluxkit::table-head>
                <tbody>
                    <tr class="border-t border-neutral-100 align-top">
                        <td class="px-3 py-2">
                            <x-fluxkit::row-select-button action="select(1)" :selected="true">山田 太郎</x-fluxkit::row-select-button>
                            <x-fluxkit::cell-sub>名前の下に積む補足 (cell-sub)</x-fluxkit::cell-sub>
                        </td>
                        <td class="px-3 py-2 wrap-anywhere">taro@example.com</td>
                        <td class="px-3 py-2 text-end tabular-nums">12</td>
                    </tr>
                    <x-fluxkit::sub-row :cols="3">
                        <x-fluxkit::delete-button action="delete(1)" confirm="削除しますか？" />
                    </x-fluxkit::sub-row>
                    <tr class="border-t border-neutral-100 align-top">
                        <td class="px-3 py-2">鈴木 花子</td>
                        <td class="px-3 py-2 wrap-anywhere">hanako@example.com</td>
                        <td class="px-3 py-2 text-end tabular-nums">3</td>
                    </tr>
                </tbody>
            </table>
            <x-fluxkit::table-pager :paginator="$many" per-page="perPage" />
        </x-fluxkit::card>
        <x-fluxkit::card class="overflow-x-auto">
            <table class="w-full text-sm">
                <x-fluxkit::table-head><tr><th class="px-3 py-2 font-medium">名前</th></tr></x-fluxkit::table-head>
                <tbody>
                    <x-fluxkit::empty-row :cols="1">行が無いときの 1 行 (empty-row)</x-fluxkit::empty-row>
                </tbody>
            </table>
            <x-fluxkit::table-pager :paginator="$none" per-page="perPage" />
        </x-fluxkit::card>
        <div class="flex items-center gap-2">
            <flux:text>page-nav だけ:</flux:text>
            <x-fluxkit::page-nav :paginator="$many" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">empty-note・empty-state</flux:heading>
        <x-fluxkit::empty-note>一覧が空のときの小さな一文 (empty-note)</x-fluxkit::empty-note>
        <x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center">
            <flux:heading>まだ何もありません (empty-state)</flux:heading>
        </x-fluxkit::empty-state>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">name-badge・required-badge</flux:heading>
        <div class="flex flex-wrap items-center gap-2">
            <x-fluxkit::name-badge name="営業部" color="blue" />
            <x-fluxkit::name-badge name="とても長い名前は幅で切って title で全体を見せる" color="green" />
            <label for="fluxkit-preview-required" class="text-sm">コード <x-fluxkit::required-badge /></label>
            <input id="fluxkit-preview-required" aria-required="true" class="rounded-md border border-zinc-200 px-2 py-1 text-sm" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">delete-button・row-select-button・sort-handle</flux:heading>
        <div class="flex flex-wrap items-center gap-3">
            <x-fluxkit::delete-button action="delete(1)" confirm="削除しますか？" />
            <x-fluxkit::delete-button action="delete(2)" size="sm" :danger="true" />
            <x-fluxkit::delete-button action="remove(3)" label="外す" />
            <x-fluxkit::row-select-button action="select(2)">押すと詳細を開く名前</x-fluxkit::row-select-button>
            <x-fluxkit::sort-handle name="ルール A" />
            <x-fluxkit::sort-handle name="ルール B" :wide="false" />
        </div>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">search-input</flux:heading>
        <x-fluxkit::search-input model="search" label="ユーザーを検索" placeholder="氏名・メールアドレスで検索" class="w-72" />
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">dashed-box</flux:heading>
        <x-fluxkit::dashed-box as="form" method="POST" wire:submit="add" class="flex flex-wrap items-end gap-2">
            <flux:input :label="'名前'" />
            <flux:button type="submit" variant="primary">追加</flux:button>
        </x-fluxkit::dashed-box>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">pane</flux:heading>
        <x-fluxkit::pane name="demo">
            <x-slot:header>
                <flux:text class="text-xs font-medium text-zinc-500">ペインの題名</flux:text>
                <flux:button size="xs" variant="ghost">右のボタン</flux:button>
            </x-slot:header>
            <div class="p-3 text-sm">ペインの中身</div>
        </x-fluxkit::pane>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">admin-page</flux:heading>
        <x-fluxkit::card class="p-4">
            <x-fluxkit::admin-page icon="cog-6-tooth" title="システム設定" heading="画面の見出し" subheading="何を設定する画面かの 1 文">
                <x-fluxkit::empty-note>本文</x-fluxkit::empty-note>
            </x-fluxkit::admin-page>
        </x-fluxkit::card>
    </section>

    <section class="flex flex-col gap-2">
        <flux:heading size="lg">busy</flux:heading>
        <flux:text>Livewire の要求が 200ms を超えたあいだだけ、画面のいちばん上に出る (このプレビューでは出ない)。</flux:text>
        <x-fluxkit::busy />
    </section>
</main>

@livewireScripts
@fluxScripts(['nonce' => Vite::cspNonce()])
</body>
</html>
