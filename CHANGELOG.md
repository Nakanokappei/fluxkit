# Changelog

## Unreleased

- The preview (`/fluxkit-preview`) is now a set of sample screens in tabs — users, inbox, labels, logs, first run —
  that use all 20 components the way an app would, instead of a list of components (`?pattern=…`; patterns in
  `resources/views/preview/`)
- `search-input`: width classes passed as `class` (e.g. `w-72`) now take effect. Previously `class` went to flux:input's
  wrapper, whose own `w-full` won, so the field was always full width. `class` now goes to a wrapping `<div>`; without a
  width class the field stays full width. Screens that passed a width will now render at that width

## v0.2.0 (2026-11-19)

- **Translation keys are now English.** Components call `__('Delete')` instead of `__('削除')`. `lang/en.json` is gone and
  the Japanese text moved to `lang/ja.json`, so apps with `APP_LOCALE=ja` render the same as before.
  If your app's `lang/<locale>.json` overrides fluxkit's text, rename those keys to the English ones (see `lang/ja.json`)
- The 0-results count reads "0 items" and the range reads ":from–:to of :total" in English
- Licensed under MIT (`LICENSE`)
- All documentation and code comments are now in English

## v0.1.2 (2026-11-17)

- The `sort-handle` grip icon (Lucide's grip-vertical) now ships inside fluxkit (`x-fluxkit::icon.grip-vertical`).
  Previously it relied on the app's `resources/views/flux/icon/grip-vertical.blade.php` and returned a 500 in apps without it.
  Rendering is unchanged
- Playground (`playground/`): a throwaway Laravel app (Docker) for viewing and fixing components on their own

## v0.1.1 (2026-11-16)

- Removed `__('…')` from the examples in component header comments (so apps that collect translation keys do not count
  example text as keys). Rendering is unchanged

## v0.1.0 (2026-11-16)

- First release. 20 components — card, table-head, sortable-th, cell-sub, sub-row, empty-row, table-pager, page-nav,
  empty-note, empty-state, name-badge, required-badge, delete-button, row-select-button, sort-handle, search-input,
  dashed-box, pane, admin-page, busy — and the preview (`/fluxkit-preview`)
