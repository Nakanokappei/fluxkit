{{--
    Page navigation.

        |<  <  [ 3 ] / 12  >  >|

    First, previous, page number, next, last. Type a number in the field and press Enter (or leave the field)
    to jump to that page. Out-of-range numbers (0, or more than the page count) snap to the nearest end;
    anything that is not a number reverts to the previous value.

    Under a table, x-fluxkit::table-pager uses this internally. When placing it alone (e.g. in a toolbar),
    the caller owns the item count and the rows-per-page select.

        <x-fluxkit::page-nav :paginator="$users" />

      paginator  LengthAwarePaginator (the total page count is needed, so simplePaginate cannot be passed)

    Navigation calls gotoPage / previousPage / nextPage of Livewire's WithPagination directly
    (not a link navigation, so only the list re-renders). **When two sit on one screen, give them
    different page names** — otherwise both buttons move the same one.

    The number field's wire:key includes the current and last page, so it is rebuilt on every page change.
    Without that, a half-typed number survives the re-render. A jump dispatches `page-jumped`
    (useful for scrolling back to the top). Clamping and writing back the number is pageNavInput (pickPage)
    in the package's resources/js/fluxkit.js (the app's JS calls registerFluxkitComponents).
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
        :tooltip="__('First page')"
        aria-label="{{ __('First page') }}"
    />
    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-left"
        icon:variant="micro"
        wire:click="previousPage('{{ $pageName }}')"
        :disabled="$paginator->onFirstPage()"
        :tooltip="__('Previous page')"
        aria-label="{{ __('Previous page') }}"
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
            aria-label="{{ __('Page number') }}"
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
        :tooltip="__('Next page')"
        aria-label="{{ __('Next page') }}"
    />
    <flux:button
        variant="ghost"
        size="xs"
        icon="chevron-double-right"
        icon:variant="micro"
        wire:click="gotoPage({{ $last }}, '{{ $pageName }}')"
        :disabled="! $paginator->hasMorePages()"
        :tooltip="__('Last page')"
        aria-label="{{ __('Last page') }}"
    />
</div>
