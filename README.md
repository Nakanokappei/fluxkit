# fluxkit

A set of anonymous Blade components for Laravel apps built with Livewire 4 + Flux 2 (20 components such as `<x-fluxkit::card>`).
Plain building blocks like buttons, inputs and modals are left to Flux; fluxkit only provides the "screen shapes" Flux lacks
(table frames, headers and pagers, the line shown when a list is empty, name badges, a standard delete button, and so on).

- Requirements: PHP 8.4+, Laravel 13, Livewire 4, Flux 2, Tailwind v4 (Vite)
- Usage (installation, Tailwind and JS setup, props and examples per component, rules to follow): [SKILL.md](SKILL.md)
  (doubles as a Claude Code skill; copy it to `~/.claude/skills/fluxkit/SKILL.md` to have it loaded in every project)
- Component preview: `GET /fluxkit-preview` in development (`APP_ENV=local`)
- UI text is English; a Japanese translation ships in `lang/ja.json`

## Installation (summary)

```json
"repositories": [{ "type": "vcs", "url": "https://github.com/Nakanokappei/fluxkit" }],
"require": { "cc9/fluxkit": "^0.2" }
```

```css
@import '../../vendor/cc9/fluxkit/resources/css/fluxkit.css';
@source '../../vendor/cc9/fluxkit/resources/views';
```

```js
import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';
document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
```

## Versions

Git tags (`v0.2.0`, etc.). Changes are in [CHANGELOG.md](CHANGELOG.md).

## License

[MIT](LICENSE)
