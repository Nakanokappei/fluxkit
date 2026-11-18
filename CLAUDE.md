# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

Everything in this repository — docs, code comments, UI text, commit messages — is written in English.

## What this is

A set of anonymous Blade components for Laravel apps built with Livewire 4 + Flux 2 (20 components such as `<x-fluxkit::card>`).
**Public repository** (github.com/Nakanokappei/fluxkit, MIT). The component list, props, usage and rules live in **`SKILL.md`** (read it first).

- **Never write business terms, customer names, URLs or account IDs of the apps using fluxkit here** (it is public; comments and examples too)
- Do not put `__('…')` in the examples of component header comments (apps that collect translation keys would pick them up; v0.1.1)

## How it fits together (spanning several files)

- `src/FluxkitServiceProvider.php` is the single entry point: registers `resources/views/components` as the anonymous component
  namespace `fluxkit`, loads `lang/` as JSON translations, and adds the preview route only when `config('fluxkit.preview.enabled')`
- Components are class-less Blade only (taking `@props`). Icons are kept in `components/icon/` too (v0.1.2; no reliance on the app's Flux icons)
- UI text is written in components as English `__('…')`; the English text is the key. The Japanese translation is `lang/ja.json`.
  The consuming app's `lang/<locale>.json` wins. Renaming a key is a breaking change for apps that override it
- Behavior lives in `resources/js/fluxkit.js` as `Alpine.data` so the CSP build of Alpine can read it; Blade calls it as
  `x-data="name(…)"` (never write `x-data="{ … }"` with arrow functions or methods in Blade attributes)
- Styling is Tailwind v4 classes; consuming apps pick up fluxkit's views with `@source`. Component-specific CSS is `resources/css/fluxkit.css`
- Per-app values live in `config/fluxkit.php` (`page_sizes`, etc.). Do not bring `App\…` classes or route names into components

## Change and verify

There are no tests, linters or build steps. Verification is the playground screen only.

```bash
cd playground && docker compose up --build    # http://localhost:8095/fluxkit-preview
```

- `setup.sh` creates a Laravel app in `playground/app` (not committed) and symlinks this repository via a composer path repository.
  To rebuild, delete `playground/app` and start again. Set `APP_LOCALE=ja` in `playground/app/.env` to check `lang/ja.json`
- The preview is outside any Livewire component, so `wire:click` does nothing. To check behavior, add a Livewire component to `playground/app`
- Component edits show up immediately (`playground/README.md`). When adding a component, add it to a preview pattern in `resources/views/preview/` too
- **Default looks and prop names affect every app using fluxkit.** Ask the user before changing them

## Releasing

1. Update `SKILL.md` (component list, props, examples), `CHANGELOG.md` and, if needed, `lang/ja.json` in the same commit
2. Commit, tag the version and push (`git tag -a v0.2.0 -m v0.2.0 && git push origin main v0.2.0`).
   Minor if default looks, props or translation keys changed; patch if only added or fixed
3. In each consuming app, run `composer update cc9/fluxkit` and put `composer.lock` in a PR (following that app's PR process)
4. Recopy the personal skill copies (`~/.claude/skills/fluxkit/SKILL.md` and Windows' `C:\Users\<user>\.claude\skills\fluxkit\SKILL.md`)

## Working on the Mac

- The repository is on the shared SSD at `/Volumes/Satechi SSD/01_Active/fluxkit`. Run git and docker directly on the Mac
- Access from Windows creates `._` files. If they show up in `git status` before committing, remove them with `dot_clean .`

## Working on Windows (desktop app + WSL2)

- The repository is `~/fluxkit` in WSL2. **Run git and docker in WSL2** (never commit with Windows git; it drops the executable bit).
  Write complex commands to `/tmp/<date>-<name>.sh` and run them with `MSYS_NO_PATHCONV=1 wsl.exe -d Ubuntu bash /tmp/…`
- After rewriting `playground/start.sh` or `setup.sh` with Edit/Write, restore `chmod 755` in WSL. Line endings are LF

## Either machine

- The author is `nakano.kappei@gmail.com` (this repository's git config; it is public, so never use a work address)
- Commit messages in English, ending with a Co-Authored-By line
