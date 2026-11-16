{{-- 一覧の検索欄。打つ間の待ち・消し方 (欄の ×)・type=search・aria-label を揃える。

        <x-fluxkit::search-input model="search" :label="__('ユーザーを検索')"
            :placeholder="__('氏名・メールアドレスで検索')" class="w-72" data-test="user-search" />

      model     打った語を受ける Livewire のプロパティ (wire:model.live.debounce)
      label     読み上げの名前 (aria-label)。見出しの隣に置くので画面には出ない
      debounce  打ち終えてから送るまでのミリ秒。既定 400。検索ごとに記録などを残す画面では、
                変えると記録の件数が変わる

    消すのは欄の × (clearable)。ほかの属性 (placeholder・size・class・data-test) は flux:input に渡る。
    「押して探す」形の欄には使わない。 --}}
@props(['model', 'label', 'debounce' => 400])

<flux:input type="search" icon="magnifying-glass" clearable :aria-label="$label"
    :attributes="$attributes->merge(['wire:model.live.debounce.'.$debounce.'ms' => $model])" />
