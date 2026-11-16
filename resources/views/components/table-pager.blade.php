{{--
    表の下に置くページャ。1 ページの行数の選択・件数・ページの移動を 1 行に並べる。

        1 ページの行数 [10]   1–10 / 25 件   |<  <  [1] / 3  >  >|

    件数に関わらず出す (表では 1 ページの行数をいつでも変えられるように)。ページの移動
    (先頭・前・番号・次・最後) は x-fluxkit::page-nav。

        <x-fluxkit::table-pager :paginator="$users" per-page="perPage" />

      paginator  LengthAwarePaginator
      per-page   1 ページの行数を持つ Livewire のプロパティ名
      options    1 ページの行数の選択肢。既定は config fluxkit.page_sizes (10・25・50・100)。行数を受け取る
                 Livewire の検証と同じ一覧にする (アプリの config/fluxkit.php で上書きできる)

    表との区切りの線はここが持つ。表の枠 (x-fluxkit::card) の中、表のすぐ下に置く。

    **1 画面に 2 つ並べるときは、ページ番号のパラメータ名を分ける** (paginate の pageName)。
    分けないと、どちらを押しても同じページが動く。
--}}
@props(['paginator', 'perPage', 'options' => null])

<div class="flex flex-wrap items-center justify-end gap-3 border-t border-neutral-100 px-3 py-2">
    <div class="flex items-center gap-2">
        <flux:text class="whitespace-nowrap text-xs text-zinc-500">{{ __('1 ページの行数') }}</flux:text>
        <flux:select wire:model.live="{{ $perPage }}" size="sm" class="w-20" :aria-label="__('1 ページの行数')">
            @foreach ($options ?? config('fluxkit.page_sizes') as $size)
                <flux:select.option value="{{ $size }}">{{ $size }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <flux:text class="whitespace-nowrap text-xs tabular-nums text-zinc-500">
        @if ($paginator->total() === 0)
            {{ __('0 件') }}
        @else
            {{ __(':from–:to / :total 件', [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ]) }}
        @endif
    </flux:text>

    <x-fluxkit::page-nav :paginator="$paginator" />
</div>
