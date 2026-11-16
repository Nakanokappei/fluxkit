{{--
    ドラッグで並べ替える行のつまみ (Livewire の wire:sort:handle)。行 (wire:sort:item) と並べ替えの
    呼び出し (wire:sort) は呼ぶ側に置く。

        <x-fluxkit::sort-handle :name="$rule->name" />

      name  読み上げの「:name をドラッグして並べ替え」に入る名前
      wide  true (既定) なら幅 w-10、false なら w-8 (列が詰まった表)

    data-test の既定は drag-handle (渡せば差し替わる)。dark: は付けていない。
--}}
@props(['name', 'wide' => true])

<div wire:sort:handle
    {{ $attributes->merge(['data-test' => 'drag-handle'])->class([
        'flex h-8 cursor-grab items-center justify-center rounded-md border border-neutral-200 bg-zinc-50 text-zinc-500 hover:border-neutral-300 hover:bg-zinc-100 hover:text-zinc-800 active:cursor-grabbing',
        'w-10' => $wide,
        'w-8' => ! $wide,
    ]) }}
    title="{{ __('ドラッグして並べ替え') }}"
    aria-label="{{ __(':name をドラッグして並べ替え', ['name' => $name]) }}">
    <flux:icon.grip-vertical variant="mini" />
</div>
