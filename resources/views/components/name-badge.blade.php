{{--
    部署・ラベルなど、利用者が付けた名前を載せるバッジ。Flux のバッジは whitespace-nowrap で折り返さない
    ので、長い名前が行や列を横に押し広げる。幅に上限を付け、はみ出したぶんは … で切り、全体は title で見せる。

        <x-fluxkit::name-badge :name="$team->name" color="blue" />
        <x-fluxkit::name-badge :name="$tag['name']" :title="$tag['note']" color="sky" />

      name     載せる名前
      title    ポインタを載せたときに出す文。既定は name (切れていなくても出す)
      max      幅の上限の Tailwind のクラス。既定は max-w-48 (12rem。全角で 14 字ほど)。変えるときは
               クラスをそのまま書く (Tailwind は views の中の literal なクラスだけを拾う)
      color・variant・icon  flux:badge にそのまま渡す

    ほかの属性 (class・style・data-test) もバッジに付く。size は sm に決めてある。横に並べて行が
    詰まったときに縮ませたくない所には class="shrink-0" を渡す。役割・状態など、語が決まっていて短い
    バッジには使わない (flux:badge のまま)。
--}}
@props(['name', 'title' => null, 'max' => 'max-w-48', 'color' => null, 'variant' => null, 'icon' => null])

<flux:badge size="sm" :color="$color" :variant="$variant" :icon="$icon"
    :attributes="$attributes->merge(['title' => $title ?? $name])->class(['min-w-0', $max])">
    <span class="truncate">{{ $name }}</span>
</flux:badge>
