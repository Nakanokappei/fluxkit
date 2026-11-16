{{--
    ページの移動。

        |<  <  [ 3 ] / 12  >  >|

    先頭・前・ページ番号・次・最後。番号の欄に打って Enter (か欄を離れる) と、そのページへ
    飛ぶ。範囲の外 (0 や総ページより大きい数) は端へ寄せ、数でないものは打つ前の番号に戻す。

    表の下では x-fluxkit::table-pager が中で使う。ツールバーなどに単独で置くときは、件数の表示と
    1 ページの行数は外側が持つ。

        <x-fluxkit::page-nav :paginator="$users" />

      paginator  LengthAwarePaginator (総ページ数が要るので、simplePaginate は渡せない)

    ページ移動は Livewire の WithPagination の gotoPage / previousPage / nextPage を直接叩く
    (リンク遷移ではないので、一覧の再描画だけで済む)。**1 画面に 2 つ並べるときは、ページ番号の
    パラメータ名を分ける** — 分けないと、どちらを押しても同じ方が動く。

    番号の欄は wire:key に今のページと総ページを含めて、ページが変わるたびに作り直す。
    作り直さないと、打ちかけの数が描き替えのあとも残る。飛んだときは `page-jumped` を
    投げる (画面の上へ戻すなどに使える)。番号を丸めて欄に書き戻すのは
    パッケージの resources/js/fluxkit.js の pageNavInput (pickPage。アプリの JS で registerFluxkitComponents を呼ぶ)。
--}}
@props(['paginator'])

@php
    $pageName = $paginator->getPageName();
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
@endphp

<div class="flex items-center gap-1" data-test="page-nav-{{ $pageName }}">
    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-double-left"
        icon:variant="micro"
        wire:click="gotoPage(1, '{{ $pageName }}')"
        :disabled="$paginator->onFirstPage()"
        :tooltip="__('最初のページ')"
        aria-label="{{ __('最初のページ') }}"
    />
    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-left"
        icon:variant="micro"
        wire:click="previousPage('{{ $pageName }}')"
        :disabled="$paginator->onFirstPage()"
        :tooltip="__('前のページ')"
        aria-label="{{ __('前のページ') }}"
    />

    <div class="flex items-center gap-1 px-1 text-xs tabular-nums text-zinc-500">
        <input
            type="text"
            inputmode="numeric"
            value="{{ $current }}"
            wire:key="page-nav-{{ $pageName }}-{{ $current }}-{{ $last }}"
            x-data="pageNavInput({{ $current }}, {{ $last }})"
            x-on:keydown.enter.prevent="$el.blur()"
            x-on:change="pickPage() && $wire.gotoPage(page, '{{ $pageName }}') && $dispatch('page-jumped')"
            @disabled($last <= 1)
            class="h-6 w-10 rounded-md border border-zinc-200 bg-white px-1 text-center text-xs tabular-nums text-zinc-800 focus:border-zinc-400 focus:outline-none disabled:bg-zinc-50 disabled:text-zinc-400"
            aria-label="{{ __('ページ番号') }}"
            data-test="page-input-{{ $pageName }}"
        />
        <span class="whitespace-nowrap">/ {{ $last }}</span>
    </div>

    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-right"
        icon:variant="micro"
        wire:click="nextPage('{{ $pageName }}')"
        :disabled="! $paginator->hasMorePages()"
        :tooltip="__('次のページ')"
        aria-label="{{ __('次のページ') }}"
    />
    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-double-right"
        icon:variant="micro"
        wire:click="gotoPage({{ $last }}, '{{ $pageName }}')"
        :disabled="! $paginator->hasMorePages()"
        :tooltip="__('最後のページ')"
        aria-label="{{ __('最後のページ') }}"
    />
</div>
