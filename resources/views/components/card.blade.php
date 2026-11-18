{{--
    A "box" on a screen. Wraps lists, tables and forms.

    **It owns only the frame** — rounded corners, border, background (including dark mode). Inner padding
    and layout differ per screen, so the caller passes them as class.

        <x-fluxkit::card class="flex flex-col gap-3 p-4">…</x-fluxkit::card>

    The passed class is appended after the frame classes. Tailwind ignores class order, so the order
    does not change the look.
--}}
<div {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900']) }}>
    {{ $slot }}
</div>
