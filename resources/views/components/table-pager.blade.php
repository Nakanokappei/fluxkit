{{--
    The pager placed under a table. Rows-per-page select, item count and page navigation on one line.

        Rows per page [10]   1–10 of 25   |<  <  [1] / 3  >  >|

    Shown regardless of the item count (so rows per page can always be changed). Page navigation
    (first, previous, number, next, last) is x-fluxkit::page-nav.

        <x-fluxkit::table-pager :paginator="$users" per-page="perPage" />

      paginator  LengthAwarePaginator
      per-page   Name of the Livewire property holding rows per page
      options    Choices for rows per page. Defaults to config fluxkit.page_sizes (10, 25, 50, 100). Keep it the same
                 list as the validation of the Livewire property that receives it (overridable in the app's config/fluxkit.php)

    It owns the divider line above it. Place it inside the table's frame (x-fluxkit::card), right below the table.

    **When two sit on one screen, give them different page names** (paginate's pageName).
    Otherwise both buttons move the same page.
--}}
@props(['paginator', 'perPage', 'options' => null])

<div class="flex flex-wrap items-center justify-end gap-3 border-t border-neutral-100 px-3 py-2">
    <div class="flex items-center gap-2">
        <flux:text class="whitespace-nowrap text-xs text-zinc-500">{{ __('Rows per page') }}</flux:text>
        <flux:select wire:model.live="{{ $perPage }}" size="sm" class="w-20" :aria-label="__('Rows per page')">
            @foreach ($options ?? config('fluxkit.page_sizes') as $size)
                <flux:select.option value="{{ $size }}">{{ $size }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <flux:text class="whitespace-nowrap text-xs tabular-nums text-zinc-500">
        @if ($paginator->total() === 0)
            {{ __('0 items') }}
        @else
            {{ __(':from–:to of :total', [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ]) }}
        @endif
    </flux:text>

    <x-fluxkit::page-nav :paginator="$paginator" />
</div>
