# プレイグラウンド

fluxkit の部品を単体で見て直すための、確かめ用の Laravel（Docker）。部品のファイル（`resources/views/components/*`・
`resources/css/fluxkit.css`・`resources/js/fluxkit.js`）を直すと、そのまま画面に出る。

```bash
cd playground
docker compose up --build        # 最初の 1 回は Laravel を作るので数分かかる
```

- 部品の一覧: http://localhost:8095/fluxkit-preview （ポートは `FLUXKIT_PLAYGROUND_PORT`、Vite は `FLUXKIT_VITE_PORT`。既定 8095・5173）
- 止める: `Ctrl+C` か `docker compose down`
- 作り直す: `playground/app` を消して、もう一度 `docker compose up`

## しくみ

- `setup.sh` が `playground/app` に Laravel を作り（git には入れない）、Livewire・Flux と、composer の path リポジトリで
  このリポジトリの直下を symlink で入れる
- CSS と JS は `stubs/` の写し。Tailwind v4 は fluxkit のビューを直に `@source` で拾い、Vite の開発サーバーで作り直す
- `FLUXKIT_PREVIEW=true` でプレビューのルートを開く。DB は使わない（セッション・キャッシュはファイル）
- プレビューは Livewire のコンポーネントの中ではないので、`wire:click` などのボタンは押しても動かない。動きまで
  確かめたい部品は、`app/` に Livewire のコンポーネントを足して試す（`app/` は捨ててよい）
