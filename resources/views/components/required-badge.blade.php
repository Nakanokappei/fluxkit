{{-- 必須の欄の「必須」のバッジ。素の <label> の中に置く。

    flux:label なら `:badge="__('必須')"` を渡す (Flux が同じ見た目で描く)。素の <select> などで flux:label を
    使えないときだけ、この部品を名札の文の後ろに置く。見た目は flux:label の badge と同じクラス。読み上げは欄の
    aria-required="true" に任せるので、ここは aria-hidden (二重に読まれないように。Flux も同じ)。

        <label for="x">{{ __('コード') }} <x-fluxkit::required-badge /></label>
        <select id="x" aria-required="true">…</select>
--}}
<span class="ms-1.5 text-zinc-800/70 text-xs font-medium bg-zinc-800/5 px-1.5 py-1 -my-1 rounded-[4px]" aria-hidden="true">{{ __('必須') }}</span>
