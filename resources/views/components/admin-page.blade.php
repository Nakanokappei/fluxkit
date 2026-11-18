@props(['icon', 'title', 'heading' => '', 'subheading' => ''])

{{-- Header and body of an admin screen. On top, an icon and a large title (which admin area this is); below it,
    the screen's heading and description, then the body.

        <x-fluxkit::admin-page icon="cog-6-tooth" :title="$areaTitle" :heading="$heading" :subheading="$subheading">
            …
        </x-fluxkit::admin-page>

    Make one thin wrapper per admin area (a layout that only fixes the icon and the large title) and have each
    screen use that wrapper, so the screens line up. --}}

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="flex items-center gap-2">
        <flux:icon :icon="$icon" class="size-5 text-zinc-500 dark:text-zinc-400" />
        <flux:heading size="lg" class="!mb-0">
            {{ $title }}
        </flux:heading>
    </div>

    {{-- Body. Without min-w-0, a table inside does not shrink and overflows. --}}
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
