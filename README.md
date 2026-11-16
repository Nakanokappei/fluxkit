# fluxkit

Livewire 4 ＋ Flux 2 の Laravel アプリで使う、無名の Blade コンポーネント集（`<x-fluxkit::card>` など 20 個）。
ボタン・入力欄・モーダルなどの素の部品は Flux に任せ、Flux に無い「画面の形」（表の枠・見出し・ページャ、
空のときの一文、名前のバッジ、削除ボタンの決まった形など）だけを持つ。

- 前提: PHP 8.4 以上・Laravel 13・Livewire 4・Flux 2・Tailwind v4（Vite）
- 使い方（インストール・Tailwind と JS の設定・部品ごとの props と例・守る決まり）: [SKILL.md](SKILL.md)
  （Claude Code のスキルを兼ねる。`~/.claude/skills/fluxkit/SKILL.md` に写せば、どのプロジェクトでも読まれる）
- 部品のプレビュー: 開発環境（`APP_ENV=local`）で `GET /fluxkit-preview`

## インストール（要点）

```json
"repositories": [{ "type": "vcs", "url": "https://github.com/Nakanokappei/fluxkit" }],
"require": { "cc9/fluxkit": "^0.1" }
```

```css
@import '../../vendor/cc9/fluxkit/resources/css/fluxkit.css';
@source '../../vendor/cc9/fluxkit/resources/views';
```

```js
import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';
document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
```

## 版

git のタグ（`v0.1.0` など）。変更は [CHANGELOG.md](CHANGELOG.md)。
