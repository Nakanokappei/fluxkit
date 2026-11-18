---
name: fluxkit
description: Use the fluxkit package (cc9/fluxkit) components when building or changing UI in Laravel. Props, slots and examples of the <x-fluxkit::…> Blade components (box, table header, sortable header, pager, empty states, name badge, required badge, delete button, row-open button, drag grip, search field, dashed box, pane, admin page header, busy indicator), installation and Tailwind v4 setup, and the rules to follow. Use when building or fixing Blade or Livewire screens, when adding tables, lists, settings screens or forms, and when asked about "components", "shared components" or "fluxkit".
---

# fluxkit — Blade components layered on top of Flux

`cc9/fluxkit` bundles combinations that were written over and over in Livewire 4 + Flux 2 apps into anonymous Blade components.
**Use Flux (`<flux:button>` and so on) for plain buttons, inputs, modals and tables.** fluxkit only owns the "screen shapes"
Flux lacks (table frames, headers and pagers, the line shown when a list is empty, name badges, a standard delete button, and so on).

- Repository: https://github.com/Nakanokappei/fluxkit (**the source of truth**; apps pull a version in through composer)
- Component preview: `GET /fluxkit-preview` in development (`APP_ENV=local`) (a sample user management screen that uses every component; buttons do nothing)

## 1. Rules

1. **Do not reimplement something fluxkit already has.** Check the list below (§4) first. Use Flux for what Flux has
2. **Before building a missing component, ask the user whether it belongs in the project or in fluxkit.** Rule of thumb:
   if it is tied to business terms, models or route names, it belongs in the project (`resources/views/components/…`); if
   it would look the same in any app, it belongs in the package
3. **When changing fluxkit, update this SKILL.md in the same change** (component list, props, examples). Also update the
   preview (`resources/views/preview.blade.php`) and, when adding text, `lang/ja.json`. **Commit changes to the fluxkit
   repository, tag a version, and run `composer update cc9/fluxkit` in the apps** (never edit inside an app's `vendor/`).
   If you keep a copy at `~/.claude/skills/fluxkit/SKILL.md`, recopy it
4. **Do not bring in project-specific dependencies.** Receive `App\…` classes, models, route names and app settings via props
   or `config('fluxkit.…')` (`config/fluxkit.php`)
5. **Default looks and prop names affect every app using fluxkit.** Ask the user before changing them, and update the callers
   in the same change. When adding a prop, make its default the current look (so callers need no changes)
6. **Let callers add classes.** Use `$attributes->merge(['class' => '…'])` or `$attributes->class([...])` on the outer element.
   Pass other attributes (`data-test`, `wire:key`, `aria-*`) through there too
7. **Write text inside components as literal English `__('…')`** (the English text is the key). The Japanese translation is the
   package's `lang/ja.json`; if the app's `lang/<locale>.json` has the same key, the app wins. Make text replaceable through
   props such as `label` for screens that need different wording
8. **Only write Alpine expressions the CSP build of Alpine can read** (no arrow functions, `if`, `;`-joined statements, `?.`,
   template literals, globals, or `x-data="{…}"` with methods). Put behavior in `Alpine.data` in `resources/js/fluxkit.js` and
   call it by name from the component. Keep `$wire.method()` calls in the attributes
9. **Write `method="POST"` on components that render a `<form>`.** No inline `<script>`, `<style>` or `onclick` (CSP)
10. **Write Tailwind classes literally in the views** (assembled strings are not picked up)

## 2. Installation

Requirements: PHP 8.4+, Laravel 13, Livewire 4, Flux 2, Tailwind v4 (Vite).

Not published on Packagist. Add the GitHub repository to the app's `composer.json` (public, so no authentication needed):

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/Nakanokappei/fluxkit" }
],
"require": { "cc9/fluxkit": "^0.2" }
```

```bash
composer update cc9/fluxkit
```

- **Versions are git tags** (`v0.2.0`, etc.). Do not write `version` in composer.json. Callers pin the version via `composer.lock`
- **To try component changes in an app while editing them**, temporarily point to a local clone with a path repository
  (place it before `vcs`; do not commit it):
  `{"type": "path", "url": "../fluxkit", "options": {"symlink": true}}` and `"cc9/fluxkit": "dev-main as 0.2.x-dev"`
- Unauthenticated GitHub API calls are limited to 60 per hour, which back-to-back CI or Docker builds can hit.
  In CI, pass `{"github-oauth": {"github.com": "${{ github.token }}"}}` in `COMPOSER_AUTH`

The ServiceProvider (`Cc9\Fluxkit\FluxkitServiceProvider`) is loaded automatically (package discovery).

## 3. Tailwind, JS and configuration

**CSS** (`resources/css/app.css`, Tailwind v4):

```css
@import 'tailwindcss';
@import '../../vendor/livewire/flux/dist/flux.css';
@import '../../vendor/cc9/fluxkit/resources/css/fluxkit.css';   /* look of busy */

@source '../views';
@source '../../vendor/cc9/fluxkit/resources/views';           /* pick up the components' classes */
@source '../../vendor/livewire/flux/stubs/**/*.blade.php';
```

On Tailwind v3, add `'./vendor/cc9/fluxkit/resources/views/**/*.blade.php'` to `content` in `tailwind.config.js`.

**JS** (`resources/js/app.js`, once before Alpine starts):

```js
import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';

document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
```

Without it, the page number field of `x-fluxkit::page-nav` (and of `table-pager`, which uses it) does not work.

**Configuration** (`config/fluxkit.php`; only the keys you write override the defaults; scaffold with `php artisan vendor:publish --tag=fluxkit-config`):

| Key | Default | Meaning |
|---|---|---|
| `page_sizes` | `[10, 25, 50, 100]` | "Rows per page" of `table-pager`. Keep it the same list as the validation on the Livewire side |
| `preview.enabled` | `APP_ENV === 'local'` (override with `FLUXKIT_PREVIEW`) | Whether to register the preview route. Never enable in production |
| `preview.path` | `fluxkit-preview` | Preview URL. Apps that use the first URL segment for tenants etc. should add it to their reserved words |
| `preview.middleware` | `['web']` | |
| `preview.vite` | `['resources/css/app.css', 'resources/js/app.js']` | Vite entry points loaded in the preview's `<head>` |

**Translations**: UI text is English. A Japanese translation ships in `lang/ja.json` and applies when the app locale is `ja`.
For other locales, add the keys from `lang/ja.json` to the app's `lang/<locale>.json`.

## 4. Component list

| Component | Use |
|---|---|
| `card` | A box on a screen (only rounded corners, border, background) |
| `table-head` | Table header row (`<thead>`) |
| `sortable-th` | Header cell sorted by clicking the column header |
| `cell-sub` | A supplementary line stacked under a name inside a cell |
| `sub-row` | Second row of a table that shows one item in two rows |
| `empty-row` | The row shown when a table has no rows |
| `table-pager` | Pager under a table (rows-per-page select, item count, page navigation) |
| `page-nav` | Page navigation only (first, previous, number, next, last) |
| `empty-note` | A short line shown when a list is empty |
| `empty-state` | A large dashed "nothing here yet" box |
| `name-badge` | Badge for a user-given name (truncated by width, full name in title) |
| `required-badge` | "Required" badge for a plain `<label>` |
| `delete-button` | "Delete" button on a list row (with confirmation message) |
| `row-select-button` | Keyboard entry point for tables where clicking a row opens details |
| `sort-handle` | Grip for rows reordered by dragging |
| `search-input` | Type-to-filter search field for lists |
| `dashed-box` | Dashed box around an "add" form or bulk actions |
| `pane` | Frame with a title bar (pane) |
| `admin-page` | Admin screen header (icon and large title) and body |
| `busy` | Indicator shown while waiting for the server |

## 5. Props, slots and examples per component

For every component, attributes other than props (`class`, `data-test`, `wire:key`, `aria-*`, etc.) go on the outer element
(listed below as "attributes go to").

### card

- props: none / slot: contents / attributes go to: `<div>`
- Owns only the frame. Pass padding and layout as class

```blade
<x-fluxkit::card class="flex flex-col gap-3 p-4">…</x-fluxkit::card>
```

### table-head, sortable-th, cell-sub, sub-row, empty-row (table shape)

Standardize tables as: frame is `card class="overflow-x-auto"`, header is `table-head`, cells are `px-3 py-2`, rows are
`border-t border-neutral-100`, `empty-row` when there are no rows, and `table-pager` right below.

| Component | props | slot | Attributes go to |
|---|---|---|---|
| `table-head` | none | `<tr>…</tr>` | `<thead>` |
| `sortable-th` | `column` (column name), `sort` (column currently sorted by), `direction` (`asc`/`desc`) | header text | `<th>` |
| `cell-sub` | none | note text | `<div>` |
| `sub-row` | `cols` (colspan), `align` (`start` default / `end`) | second-row contents | `<tr>` |
| `empty-row` | `cols` (colspan) | text shown when empty | none |

- Clicking `sortable-th` calls Livewire's `sort('<column>')` (clicking the same column again reverses). It also sets `aria-sort`
- Do not put `whitespace-nowrap` on text columns. When space runs short, stack into `cell-sub` or `sub-row` instead of adding columns

```blade
<x-fluxkit::card class="overflow-x-auto">
    <table class="w-full text-sm">
        <x-fluxkit::table-head>
            <tr>
                <x-fluxkit::sortable-th column="name" :sort="$sort" :direction="$direction">{{ __('Name') }}</x-fluxkit::sortable-th>
                <th class="px-3 py-2 text-end font-medium">{{ __('Count') }}</th>
            </tr>
        </x-fluxkit::table-head>
        <tbody>
            @forelse ($users as $user)
                <tr class="border-t border-neutral-100 align-top" wire:key="user-{{ $user->id }}">
                    <td class="px-3 py-2">
                        {{ $user->name }}
                        <x-fluxkit::cell-sub>{{ $user->email }}</x-fluxkit::cell-sub>
                    </td>
                    <td class="px-3 py-2 text-end tabular-nums">{{ $user->count }}</td>
                </tr>
                <x-fluxkit::sub-row :cols="2" align="end" wire:key="user-actions-{{ $user->id }}">…buttons…</x-fluxkit::sub-row>
            @empty
                <x-fluxkit::empty-row :cols="2">{{ __('No users.') }}</x-fluxkit::empty-row>
            @endforelse
        </tbody>
    </table>
    <x-fluxkit::table-pager :paginator="$users" per-page="perPage" />
</x-fluxkit::card>
```

### table-pager, page-nav (pagination)

| Component | props |
|---|---|
| `table-pager` | `paginator` (`LengthAwarePaginator`), `per-page` (name of the Livewire property holding rows per page), `options` (rows-per-page choices; defaults to `config('fluxkit.page_sizes')`) |
| `page-nav` | `paginator` (`LengthAwarePaginator`; the total page count is needed, so `simplePaginate` is not allowed) |

- Calls `gotoPage` / `previousPage` / `nextPage` of Livewire's `WithPagination` directly
- **With two on one screen, separate the page names with `paginate(…, pageName: 'usersPage')`** (otherwise both move)
- Jumping by typed number dispatches `page-jumped` (e.g. to scroll back to the top). The number field needs fluxkit.js (§3)
- `table-pager` is shown regardless of item count (so rows per page can always be changed). It owns the divider line. It takes no attributes

```blade
<x-fluxkit::table-pager :paginator="$users" per-page="usersPerPage" />
<x-fluxkit::page-nav :paginator="$messages" />
```

### empty-note, empty-state

| Component | props | Attributes go to |
|---|---|---|
| `empty-note` | `bare` (true omits the frame; for use inside a table's frame in place of the table) | outer `<div>` |
| `empty-state` | none (only the dashed frame and centering; padding and border strength via class) | `<div>` |

```blade
<x-fluxkit::empty-note>{{ __('No items yet.') }}</x-fluxkit::empty-note>
<x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center">…</x-fluxkit::empty-state>
```

### name-badge, required-badge

| Component | props |
|---|---|
| `name-badge` | `name` (name to show), `title` (defaults to name), `max` (max-width class; default `max-w-48`), `color`, `variant`, `icon` (to `flux:badge`) |
| `required-badge` | none |

- `name-badge` is for user-given names (departments, labels, …). Keep `flux:badge` for short fixed wording such as roles or states
- `required-badge` only inside a plain `<label>`. Fields given `flux:label` / `label=` use `:badge="__('Required')"`.
  The badge is aria-hidden, so put **`aria-required="true"` on the field itself** (on components, `:aria-required="'true'"`)

```blade
<x-fluxkit::name-badge :name="$team->name" color="blue" class="shrink-0" />
<label for="code">{{ __('Code') }} <x-fluxkit::required-badge /></label>
<select id="code" aria-required="true">…</select>
```

### delete-button, row-select-button, sort-handle (row actions)

| Component | props | Attributes go to |
|---|---|---|
| `delete-button` | `action` (`wire:click`), `confirm` (`wire:confirm` text; null skips confirmation), `size` (`xs` default / `sm`), `label` (default "Delete"), `danger` (true for a red outline) | `flux:button` |
| `row-select-button` | `action` (`wire:click.stop`), `selected` (`aria-pressed`) | `<button>` |
| `sort-handle` | `name` (inserted into the accessible label "Drag :name to reorder"), `wide` (true default for `w-10`, false for `w-8`) | `<div wire:sort:handle>` (`data-test` defaults to `drag-handle`) |

- Deletes inside list rows use ghost + confirmation (the default). Use `:danger="true"` for deletes that remove whole files or always-visible cancels
- Keep `<tr wire:click>` even with `row-select-button` (so clicking anywhere on the row opens it). Pass `disabled` for rows that cannot be opened
- The `sort-handle` row (`wire:sort:item`) and the reorder call (`wire:sort`) are written by the caller

```blade
<x-fluxkit::delete-button action="delete({{ $item->id }})" :confirm="__('Delete this item? This cannot be undone.')" />
<tr wire:click="select({{ $rule->id }})">
    <td class="px-3 py-2"><x-fluxkit::row-select-button action="select({{ $rule->id }})" :selected="$isSelected">{{ $rule->name }}</x-fluxkit::row-select-button></td>
</tr>
<x-fluxkit::sort-handle :name="$rule->name" />
```

### search-input

- props: `model` (property receiving `wire:model.live.debounce`), `label` (aria-label), `debounce` (milliseconds; default 400)
- Attributes go to: `class` to a wrapping `<div>` (so width classes such as `w-72` work; full width without one), everything
  else to `flux:input` (`placeholder`, `size`, `data-test`). type=search, magnifying glass, clear with the × in the field
- Do not use it for fields that search only when a button is pressed

```blade
<x-fluxkit::search-input model="search" :label="__('Search users')" :placeholder="__('Search by name or email')" class="w-72" />
```

### dashed-box

- props: `as` (`div` default, `form`, `section`) / attributes go to: the box element
- **Write `method="POST"` when it is a form too**

```blade
<x-fluxkit::dashed-box as="form" method="POST" wire:submit="addLabel" class="flex flex-wrap items-end gap-2">…</x-fluxkit::dashed-box>
```

### pane

- props: `name` (value of `data-pane`) / slots: `header` (bar contents; title on the left, buttons on the right) and contents / attributes go to: `<section>`

```blade
<x-fluxkit::pane name="chat" class="flex flex-col">
    <x-slot:header>
        <flux:text class="text-xs font-medium text-zinc-500">{{ __('Chat') }}</flux:text>
    </x-slot:header>
    …
</x-fluxkit::pane>
```

### admin-page

- props: `icon` (Flux icon name), `title` (large title), `heading`, `subheading` (screen heading and description; omitted when empty)
- slot: body / takes no attributes. Usually called from a thin layout per admin area

```blade
<x-fluxkit::admin-page icon="cog-6-tooth" :title="__('System settings')" :heading="$heading" :subheading="$subheading">{{ $slot }}</x-fluxkit::admin-page>
```

### busy

- No props, slots or attributes. **Place it inside a Livewire component** (`wire:loading` reacts only to requests of the component it is in)
- When a request takes longer than 200ms, shows a sliding bar at the very top of the screen and "Loading…", and turns the cursor into the wait cursor.
  The look comes from `fluxkit.css` (needs the @import in §3)

```blade
<div>
    <x-fluxkit::busy />
    …
</div>
```

## 6. Adding or changing a component

1. Ask the user about rule §1.2 (where to build it)
2. Write it in `resources/views/components/<name>.blade.php`. In the header `{{-- --}}`, describe what it is, an example and its props
3. Accept the caller's classes and attributes via `$attributes->merge()` / `->class()`. Text is `__('…')` in English; make defaults replaceable via props.
   **Use only Flux's standard icons (Heroicons) via `flux:icon`.** Put anything else (Lucide, etc.) in `resources/views/components/icon/<name>.blade.php`
   and call it as `<x-fluxkit::icon.<name>>` (relying on the app's `resources/views/flux/icon/` breaks in other apps; v0.1.2)
4. If behavior is needed, add `Alpine.data` to `registerFluxkitComponents` in `resources/js/fluxkit.js`. If CSS is needed, `resources/css/fluxkit.css`
5. Update the preview (`resources/views/preview.blade.php`), this SKILL.md (§4, §5) and `lang/ja.json`
6. In an app (pointed via the path repository from §2), check that the screen's HTML is unchanged (for fixes) and that tests pass
7. Commit to the fluxkit repository and tag a version (minor if default looks or props changed, patch if only added.
   Until 1.0, bumping x in `0.x` falls outside callers' `^0.x`). Add a line to `CHANGELOG.md`
8. Run `composer update cc9/fluxkit` in the apps and commit the `composer.lock` change
