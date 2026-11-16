{{-- 追加のフォーム・一括操作の節を囲む破線の箱。

        <x-fluxkit::dashed-box as="form" method="POST" wire:submit="addLabel" class="flex flex-wrap items-end gap-2">
            …
        </x-fluxkit::dashed-box>

      as  箱の要素 (form・section・div)。既定は div

    中の並べ方 (flex・gap) は class で渡す。ほかの属性 (wire:submit・data-test) は箱に付く。
    **form にするときも method="POST" を書く** (JS が動く前に押されても、入力が URL に載らないように)。 --}}
@props(['as' => 'div'])

<{{ $as }} {{ $attributes->merge(['class' => 'rounded-xl border border-dashed border-neutral-300 p-4 dark:border-neutral-600']) }}>
    {{ $slot }}
</{{ $as }}>
