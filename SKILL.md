---
name: fluxkit
description: Laravel で UI を作る・変更するとき、fluxkit パッケージ（cc9/fluxkit）の部品を使う。<x-fluxkit::…> の Blade 部品（箱・表の見出し・並べ替えの見出し・ページャ・空のときの表示・名前のバッジ・必須のバッジ・削除ボタン・行を開くボタン・ドラッグのつまみ・検索欄・破線の箱・ペイン・管理画面の頭・処理中の印）の props・slot・使用例、インストールと Tailwind v4 の設定、守る決まり。Blade や Livewire の画面を作る・直すとき、表・一覧・設定画面・フォームを足すとき、「部品」「コンポーネント」「共通化」「fluxkit」と言われたときに使う。
---

# fluxkit — Flux の上に重ねる Blade の部品

`cc9/fluxkit` は、Livewire 4 ＋ Flux 2 のアプリで繰り返し書いていた組み合わせを、無名の Blade コンポーネントにまとめたもの。
**ボタン・入力欄・モーダル・テーブルの素の部品は Flux（`<flux:button>` など）を使う。** fluxkit は Flux に無い「画面の形」
（表の枠・見出し・ページャ、空のときの一文、名前のバッジ、削除ボタンの決まった形など）だけを持つ。

- リポジトリ: https://github.com/Nakanokappei/fluxkit（**ここが正**。使うアプリは composer で版を指して取り込む）
- 部品のプレビュー: 開発環境（`APP_ENV=local`）で `GET /fluxkit-preview`（全部品を並べる。ボタンは見た目だけ）

## 1. 守る決まり

1. **同等の部品が fluxkit にあるときは、独自に実装しない。** 先に下の一覧（§4）を見る。Flux にある部品は Flux を使う
2. **足りない部品は、作る前に「プロジェクト内で作るか、fluxkit に足すか」を利用者に確かめる。** 目安: 業務の語・モデル・
   ルート名に結びつくならプロジェクト内（`resources/views/components/…`）、どのアプリでも同じ形ならパッケージ
3. **fluxkit を変えたら、この SKILL.md も同じ変更で直す**（部品の一覧・props・例）。あわせてプレビュー
   （`resources/views/preview.blade.php`）と、文言を足したら `lang/en.json` も。**変更は fluxkit のリポジトリに入れて版の
   タグを打ち、使うアプリで `composer update cc9/fluxkit`**（アプリの `vendor/` の中を直に直さない）。個人の
   `~/.claude/skills/fluxkit/SKILL.md` に写しを置いているなら、写し直す
4. **プロジェクト固有の依存を持ち込まない。** `App\…` のクラス・モデル・ルート名・アプリの設定は、props か
   `config('fluxkit.…')`（`config/fluxkit.php`）で受け取る
5. **既定の見た目と props の名前は、使っているアプリ全部に効く。** 変えるなら利用者に確かめ、使う側を同じ変更で直す。
   足すときは既定値を今の見た目にする（呼び出しを直さずに済むように）
6. **呼び出し側でクラスを足せるようにする。** 外側の要素に `$attributes->merge(['class' => '…'])` か
   `$attributes->class([...])`。ほかの属性（`data-test`・`wire:key`・`aria-*`）もそこへ流す
7. **部品の中の文は、日本語の `__('…')` にリテラルで書く**（鍵は日本語のまま）。訳はパッケージの `lang/en.json`、
   アプリの `lang/<言語>.json` に同じ鍵があればアプリが勝つ。語を変えたい画面のために、`label` などの props で差し替えられるように
8. **Alpine の式は CSP 用の Alpine で読める形だけ**（アロー関数・`if`・`;` でつないだ文・`?.`・テンプレート文字列・グローバル・
   メソッドを持つ `x-data="{…}"` を書かない）。動きは `resources/js/fluxkit.js` の `Alpine.data` に置き、部品からは名前で呼ぶ。
   `$wire.メソッド()` の呼び出しは属性に残す
9. **`<form>` にする部品にも `method="POST"` を書く。** インラインの `<script>`・`<style>`・`onclick` は書かない（CSP）
10. **Tailwind のクラスはビューの中にリテラルで書く**（組み立てた文字列は拾われない）

## 2. インストール

前提: PHP 8.4 以上・Laravel 13・Livewire 4・Flux 2・Tailwind v4（Vite）。

Packagist には載せていない。アプリの `composer.json` に GitHub のリポジトリを足す（公開なので認証は要らない）:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/Nakanokappei/fluxkit" }
],
"require": { "cc9/fluxkit": "^0.1" }
```

```bash
composer update cc9/fluxkit
```

- **版は git のタグ**（`v0.1.0` など）。composer.json に `version` は書かない。使う側は `composer.lock` で版が固まる
- **部品を直しながらアプリで試すとき**は、手元の clone を path リポジトリで一時的に指す（`vcs` の前に置く。
  コミットしない）:
  `{"type": "path", "url": "../fluxkit", "options": {"symlink": true}}` と `"cc9/fluxkit": "dev-main as 0.1.x-dev"`
- GitHub の API を認証なしで叩くと 1 時間に 60 回までで、CI や Docker のビルドが続くと当たることがある。
  CI では `COMPOSER_AUTH` に `{"github-oauth": {"github.com": "${{ github.token }}"}}` を渡す

ServiceProvider（`Cc9\Fluxkit\FluxkitServiceProvider`）は自動で読み込まれる（package discovery）。

## 3. Tailwind・JS・設定

**CSS**（`resources/css/app.css`。Tailwind v4）:

```css
@import 'tailwindcss';
@import '../../vendor/livewire/flux/dist/flux.css';
@import '../../vendor/cc9/fluxkit/resources/css/fluxkit.css';   /* busy の見え方 */

@source '../views';
@source '../../vendor/cc9/fluxkit/resources/views';           /* 部品のクラスを拾う */
@source '../../vendor/livewire/flux/stubs/**/*.blade.php';
```

Tailwind v3 なら `tailwind.config.js` の `content` に `'./vendor/cc9/fluxkit/resources/views/**/*.blade.php'` を足す。

**JS**（`resources/js/app.js`。Alpine が始まる前に 1 回）:

```js
import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';

document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
```

呼ばないと `x-fluxkit::page-nav`（と、それを使う `table-pager`）の番号の欄が動かない。

**設定**（`config/fluxkit.php`。書いた鍵だけが既定を上書きする。`php artisan vendor:publish --tag=fluxkit-config` で雛形）:

| 鍵 | 既定 | 意味 |
|---|---|---|
| `page_sizes` | `[10, 25, 50, 100]` | `table-pager` の「1 ページの行数」。行数を受け取る Livewire の検証と同じ一覧にする |
| `preview.enabled` | `APP_ENV === 'local'`（`FLUXKIT_PREVIEW` で上書き） | プレビューのルートを登録するか。本番では付けない |
| `preview.path` | `fluxkit-preview` | プレビューの URL。URL の 1 番目をテナントなどに使うアプリは予約語に足す |
| `preview.middleware` | `['web']` | |
| `preview.vite` | `['resources/css/app.css', 'resources/js/app.js']` | プレビューの `<head>` で読む Vite の入口 |

## 4. 部品の一覧

| 部品 | 何に使う |
|---|---|
| `card` | 画面の中の箱（角丸・枠線・背景だけ） |
| `table-head` | 表の見出し行（`<thead>`） |
| `sortable-th` | 列見出しで並べ替えるセル |
| `cell-sub` | セルの中で名前の下に積む補足の 1 行 |
| `sub-row` | 1 件を 2 段で見せる表の 2 段目の行 |
| `empty-row` | 表に行が無いときの 1 行 |
| `table-pager` | 表の下のページャ（行数の選択・件数・ページの移動） |
| `page-nav` | ページの移動だけ（先頭・前・番号・次・最後） |
| `empty-note` | 一覧が空のときの小さな一文 |
| `empty-state` | 「まだ何もありません」の破線の大きな箱 |
| `name-badge` | 利用者が付けた名前のバッジ（幅で切って title） |
| `required-badge` | 素の `<label>` の「必須」のバッジ |
| `delete-button` | 一覧の行の「削除」ボタン（確かめの文つき） |
| `row-select-button` | 行を押して詳細を開く表の、キーボードの入口 |
| `sort-handle` | ドラッグで並べ替える行のつまみ |
| `search-input` | 一覧の打って絞る検索欄 |
| `dashed-box` | 追加のフォーム・一括操作を囲む破線の箱 |
| `pane` | 題名の帯の付いた枠（ペイン） |
| `admin-page` | 管理画面の頭（アイコンと大きな見出し）と本文 |
| `busy` | サーバーの処理を待っているあいだの印 |

## 5. 部品ごとの props・slot・例

どの部品も、props 以外の属性（`class`・`data-test`・`wire:key`・`aria-*` など）は外側の要素（下で「属性の行き先」）に付く。

### card

- props: なし ／ slot: 中身 ／ 属性の行き先: `<div>`
- 持つのは枠だけ。余白と並べ方は class で渡す

```blade
<x-fluxkit::card class="flex flex-col gap-3 p-4">…</x-fluxkit::card>
```

### table-head・sortable-th・cell-sub・sub-row・empty-row（表の形）

表は「枠は `card class="overflow-x-auto"`、見出しは `table-head`、セルは `px-3 py-2`、行は
`border-t border-neutral-100`、行が無いときは `empty-row`、すぐ下に `table-pager`」で揃える。

| 部品 | props | slot | 属性の行き先 |
|---|---|---|---|
| `table-head` | なし | `<tr>…</tr>` | `<thead>` |
| `sortable-th` | `column`（列の名前）・`sort`（いま並べ替えている列）・`direction`（`asc`/`desc`） | 見出しの文 | `<th>` |
| `cell-sub` | なし | 補足の文 | `<div>` |
| `sub-row` | `cols`（colspan）・`align`（`start` 既定 / `end`） | 2 段目の中身 | `<tr>` |
| `empty-row` | `cols`（colspan） | 空のときの文 | なし |

- `sortable-th` は押すと Livewire の `sort('<column>')` を呼ぶ（同じ列をもう一度で逆順）。`aria-sort` も付ける
- テキストの列に `whitespace-nowrap` を付けない。足りないときは列を増やさず `cell-sub` か `sub-row` に積む

```blade
<x-fluxkit::card class="overflow-x-auto">
    <table class="w-full text-sm">
        <x-fluxkit::table-head>
            <tr>
                <x-fluxkit::sortable-th column="name" :sort="$sort" :direction="$direction">{{ __('氏名') }}</x-fluxkit::sortable-th>
                <th class="px-3 py-2 text-end font-medium">{{ __('件数') }}</th>
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
                <x-fluxkit::sub-row :cols="2" align="end" wire:key="user-actions-{{ $user->id }}">…ボタン…</x-fluxkit::sub-row>
            @empty
                <x-fluxkit::empty-row :cols="2">{{ __('ユーザーはいません。') }}</x-fluxkit::empty-row>
            @endforelse
        </tbody>
    </table>
    <x-fluxkit::table-pager :paginator="$users" per-page="perPage" />
</x-fluxkit::card>
```

### table-pager・page-nav（ページ送り）

| 部品 | props |
|---|---|
| `table-pager` | `paginator`（`LengthAwarePaginator`）・`per-page`（1 ページの行数を持つ Livewire のプロパティ名）・`options`（行数の選択肢。既定は `config('fluxkit.page_sizes')`） |
| `page-nav` | `paginator`（`LengthAwarePaginator`。総ページ数が要るので `simplePaginate` は不可） |

- Livewire の `WithPagination` の `gotoPage` / `previousPage` / `nextPage` を直接呼ぶ
- **1 画面に 2 つ置くなら、`paginate(…, pageName: 'usersPage')` でページ番号の名前を分ける**（分けないと両方が動く）
- 番号を打って飛んだら `page-jumped` を dispatch する（上へ戻すなどに使う）。番号の欄には fluxkit.js が要る（§3）
- `table-pager` は件数に関わらず出す（行数をいつでも変えられるように）。区切りの線も持つ。属性は受け取らない

```blade
<x-fluxkit::table-pager :paginator="$users" per-page="usersPerPage" />
<x-fluxkit::page-nav :paginator="$messages" />
```

### empty-note・empty-state

| 部品 | props | 属性の行き先 |
|---|---|---|
| `empty-note` | `bare`（true なら枠を付けない。表の枠の中で表の代わりに出すとき） | 外側の `<div>` |
| `empty-state` | なし（破線の枠と中央寄せだけ。余白・枠の濃さは class で） | `<div>` |

```blade
<x-fluxkit::empty-note>{{ __('項目はまだありません。') }}</x-fluxkit::empty-note>
<x-fluxkit::empty-state class="border-neutral-300 bg-white p-12 text-center">…</x-fluxkit::empty-state>
```

### name-badge・required-badge

| 部品 | props |
|---|---|
| `name-badge` | `name`（載せる名前）・`title`（既定は name）・`max`（幅の上限のクラス。既定 `max-w-48`）・`color`・`variant`・`icon`（`flux:badge` へ） |
| `required-badge` | なし |

- `name-badge` は利用者が付けた名前（部署・ラベルなど）用。役割・状態のように語が決まって短いものは `flux:badge` のまま
- `required-badge` は素の `<label>` の中だけ。`flux:label` / `label=` を渡す欄は `:badge="__('必須')"` を使う。
  バッジは aria-hidden なので、**欄そのものに `aria-required="true"`**（部品には `:aria-required="'true'"`）

```blade
<x-fluxkit::name-badge :name="$team->name" color="blue" class="shrink-0" />
<label for="code">{{ __('コード') }} <x-fluxkit::required-badge /></label>
<select id="code" aria-required="true">…</select>
```

### delete-button・row-select-button・sort-handle（行の操作）

| 部品 | props | 属性の行き先 |
|---|---|---|
| `delete-button` | `action`（`wire:click`）・`confirm`（`wire:confirm` の文。null なら確かめない）・`size`（`xs` 既定 / `sm`）・`label`（既定「削除」）・`danger`（true で赤枠） | `flux:button` |
| `row-select-button` | `action`（`wire:click.stop`）・`selected`（`aria-pressed`） | `<button>` |
| `sort-handle` | `name`（読み上げの「:name をドラッグして並べ替え」）・`wide`（true 既定で `w-10`、false で `w-8`） | `<div wire:sort:handle>`（`data-test` の既定は `drag-handle`） |

- 一覧の行の中の削除は ghost ＋確かめ（既定）。ファイルごと消えるもの・常に見える中止は `:danger="true"`
- `row-select-button` を使っても `<tr wire:click>` は残す（マウスで行のどこを押しても開く）。押せない行は `disabled`
- `sort-handle` の行（`wire:sort:item`）と並べ替えの呼び出し（`wire:sort`）は呼ぶ側に書く

```blade
<x-fluxkit::delete-button action="delete({{ $item->id }})" :confirm="__('この項目を削除します。元に戻せません。よろしいですか？')" />
<tr wire:click="select({{ $rule->id }})">
    <td class="px-3 py-2"><x-fluxkit::row-select-button action="select({{ $rule->id }})" :selected="$isSelected">{{ $rule->name }}</x-fluxkit::row-select-button></td>
</tr>
<x-fluxkit::sort-handle :name="$rule->name" />
```

### search-input

- props: `model`（`wire:model.live.debounce` で受けるプロパティ）・`label`（aria-label）・`debounce`（ミリ秒。既定 400）
- 属性の行き先: `flux:input`（`placeholder`・`size`・`class`・`data-test`）。type=search・虫めがね・欄の × で消す
- 「押して探す」形の欄には使わない

```blade
<x-fluxkit::search-input model="search" :label="__('ユーザーを検索')" :placeholder="__('氏名・メールアドレスで検索')" class="w-72" />
```

### dashed-box

- props: `as`（`div` 既定・`form`・`section`） ／ 属性の行き先: 箱の要素
- **form にするときも `method="POST"` を書く**

```blade
<x-fluxkit::dashed-box as="form" method="POST" wire:submit="addLabel" class="flex flex-wrap items-end gap-2">…</x-fluxkit::dashed-box>
```

### pane

- props: `name`（`data-pane` の値）／ slot: `header`（帯の中身。左に題名、右にボタン）と中身 ／ 属性の行き先: `<section>`

```blade
<x-fluxkit::pane name="chat" class="flex flex-col">
    <x-slot:header>
        <flux:text class="text-xs font-medium text-zinc-500">{{ __('チャット') }}</flux:text>
    </x-slot:header>
    …
</x-fluxkit::pane>
```

### admin-page

- props: `icon`（Flux のアイコン名）・`title`（大きな見出し）・`heading`・`subheading`（画面の見出しと説明。空なら出さない）
- slot: 本文 ／ 属性は受け取らない。ふつうは管理の種類ごとの薄いレイアウトから呼ぶ

```blade
<x-fluxkit::admin-page icon="cog-6-tooth" :title="__('システム設定')" :heading="$heading" :subheading="$subheading">{{ $slot }}</x-fluxkit::admin-page>
```

### busy

- props・slot・属性なし。**Livewire のコンポーネントの中に置く**（`wire:loading` は置いたコンポーネントの要求にだけ反応する）
- 要求が 200ms を超えたら、画面のいちばん上に流れる帯と「読み込んでいます…」を出し、カーソルを待ちの形にする。
  見え方は `fluxkit.css`（§3 の @import が要る）

```blade
<div>
    <x-fluxkit::busy />
    …
</div>
```

## 6. 部品を足す・直すとき

1. 決まり §1 の 2（どこに作るか）を利用者に確かめる
2. `resources/views/components/<名前>.blade.php` に書く。頭の `{{-- --}}` に、何の部品か・例・props を書く
3. `$attributes->merge()` / `->class()` で呼び出し側のクラスと属性を受ける。文言は `__('…')`、既定値は props で差し替えられるように
4. 動きが要るなら `resources/js/fluxkit.js` の `registerFluxkitComponents` に `Alpine.data` を足す。CSS が要るなら `resources/css/fluxkit.css`
5. プレビュー（`resources/views/preview.blade.php`）・この SKILL.md（§4・§5）・`lang/en.json` を直す
6. 使うアプリで（§2 の path で指して）、画面の HTML が変わっていないか（直したとき）・テストが通るかを確かめる
7. fluxkit のリポジトリにコミットして、版のタグを打つ（既定の見た目や props を変えたら minor、足しただけなら patch。
   1.0 までは `0.x` の x を上げると使う側の `^0.x` から外れる）。`CHANGELOG.md` に 1 行足す
8. 使うアプリで `composer update cc9/fluxkit` して、`composer.lock` の変更をコミットする
