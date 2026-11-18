{{--
    A dashed "nothing here yet" box that emphasizes there is no data.

    **It owns only the dashed frame and centering.** Padding and border strength differ per screen
    (some screens emphasize the absence of data, others just mention it), so the caller passes them as class.

        <x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center dark:bg-zinc-900">…</x-fluxkit::empty-state>
--}}
<div {{ $attributes->merge(['class' => 'flex flex-1 flex-col items-center justify-center gap-3 rounded-xl border border-dashed dark:border-neutral-700']) }}>
    {{ $slot }}
</div>
