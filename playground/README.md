# Playground

A throwaway Laravel app (Docker) for viewing and fixing fluxkit components on their own. Edits to the component files
(`resources/views/components/*`, `resources/css/fluxkit.css`, `resources/js/fluxkit.js`) show up on screen immediately.

```bash
cd playground
docker compose up --build        # the first run creates the Laravel app and takes a few minutes
```

- Component list: http://localhost:8095/fluxkit-preview (ports: `FLUXKIT_PLAYGROUND_PORT` and `FLUXKIT_VITE_PORT`; defaults 8095 and 5173)
- Stop: `Ctrl+C` or `docker compose down`
- Rebuild: delete `playground/app` and run `docker compose up` again
- Japanese: set `APP_LOCALE=ja` in `playground/app/.env` to check `lang/ja.json`

## How it works

- `setup.sh` creates a Laravel app in `playground/app` (not committed) and installs Livewire, Flux and, through a composer
  path repository, the root of this repository via symlink
- The CSS and JS are copies from `stubs/`. Tailwind v4 picks up fluxkit's views directly via `@source`, rebuilt by the Vite dev server
- `FLUXKIT_PREVIEW=true` enables the preview route. No DB is used (sessions and cache are files)
- The preview is not inside a Livewire component, so buttons such as `wire:click` do nothing. To check behavior,
  add a Livewire component to `app/` and try it there (`app/` is disposable)
