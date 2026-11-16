# 変更の記録

## v0.1.2 (2026-11-17)

- `sort-handle` のつまみのアイコン（Lucide の grip-vertical）を fluxkit の中に持った（`x-fluxkit::icon.grip-vertical`）。
  それまでは使うアプリの `resources/views/flux/icon/grip-vertical.blade.php` に頼っていて、持たないアプリでは 500 になった。
  描画は変わらない
- プレイグラウンド（`playground/`）: 部品を単体で見て直すための確かめ用の Laravel（Docker）

## v0.1.1 (2026-11-16)

- 部品の頭のコメントの例から `__('…')` を外した（訳のファイルの鍵を数えるアプリで、例の文が鍵に数えられないように）。
  描画は変わらない

## v0.1.0 (2026-11-16)

- 最初の版。card・table-head・sortable-th・cell-sub・sub-row・empty-row・table-pager・page-nav・empty-note・
  empty-state・name-badge・required-badge・delete-button・row-select-button・sort-handle・search-input・
  dashed-box・pane・admin-page・busy の 20 部品と、プレビュー（`/fluxkit-preview`）
