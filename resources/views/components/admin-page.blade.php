@props(['icon', 'title', 'heading' => '', 'subheading' => ''])

{{-- 管理の画面の頭と本文。上にアイコンと大きな見出し (どの管理か)、その下に画面の見出しと説明、本文。

        <x-fluxkit::admin-page icon="cog-6-tooth" :title="__('システム設定')" :heading="__('ユーザー')" :subheading="__('…')">
            …
        </x-fluxkit::admin-page>

    管理の種類ごとに薄い包み (アイコンと大きな見出しだけを決めるレイアウト) を作り、各画面はその包みを使うと揃う。 --}}

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="flex items-center gap-2">
        <flux:icon :icon="$icon" class="size-5 text-zinc-500 dark:text-zinc-400" />
        <flux:heading size="lg" class="!mb-0">
            {{ $title }}
        </flux:heading>
    </div>

    {{-- 本文。min-w-0 が無いと、中の表が縮まずに外へはみ出す。 --}}
    <div class="flex min-w-0 flex-1 flex-col gap-4 self-stretch">
        @if ($heading || $subheading)
            <div class="flex flex-col gap-1">
                @if ($heading)
                    <flux:heading size="md">{{ $heading }}</flux:heading>
                @endif
                @if ($subheading)
                    <flux:subheading>{{ $subheading }}</flux:subheading>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
