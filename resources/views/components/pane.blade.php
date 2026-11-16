{{--
    詳細画面などに並べるペイン。枠と、題名の帯 (左に題名、右にボタン) を持つ。

        <x-fluxkit::pane name="chat">
            <x-slot:header>
                <flux:text class="text-xs font-medium text-zinc-500">{{ __('チャット') }}</flux:text>
            </x-slot:header>
            …
        </x-fluxkit::pane>

      name    data-pane の値 (テストや、ペインの並べ替えの目印)
      header  帯の中身。左に題名、右にボタン (両端に寄せる)

    渡した class は枠のうしろに足される (縦に並べるペインは flex flex-col)。
--}}
@props(['name', 'header'])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200']) }} data-pane="{{ $name }}">
    <div class="flex items-center justify-between gap-2 border-b border-neutral-200 px-3 py-1.5">
        {{ $header }}
    </div>
    {{ $slot }}
</section>
