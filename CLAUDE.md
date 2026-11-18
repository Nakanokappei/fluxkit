# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

fluxkit（`cc9/fluxkit`）で Claude Code が作業するときの指針。**日本語で書き、チャットの返答も日本語で**（識別子は英語）。

## これは何か

Livewire 4 ＋ Flux 2 の Laravel アプリで使う、無名の Blade コンポーネント集（`<x-fluxkit::card>` など 20 個）。
**公開リポジトリ**（github.com/Nakanokappei/fluxkit）。部品の一覧・props・使い方・守る決まりは **`SKILL.md`**（最初に読む）。

- **使っているアプリの業務の語・顧客名・URL・アカウント ID をここに書かない**（公開。コメントや例も同じ）
- 部品の頭のコメントの例に `__('…')` を書かない（使う側の訳のファイルの鍵の数え上げに拾われる。v0.1.1）

## しくみ（複数のファイルにまたがる話）

- `src/FluxkitServiceProvider.php` が全部の入口: `resources/views/components` を無名コンポーネントの名前空間 `fluxkit` に登録、
  `lang/` を JSON の訳として読み込み、`config('fluxkit.preview.enabled')` のときだけプレビューのルートを足す
- 部品はクラスを持たない Blade だけ（`@props` で受ける）。アイコンも `components/icon/` に持つ（v0.1.2。Flux のアイコンに頼らない）
- 文言は部品の中に日本語の `__('…')` で書き、鍵も日本語。英訳は `lang/en.json`。使う側のアプリの `lang/<言語>.json` が勝つ
- 動きのある部品は、CSP 用の Alpine で読めるよう `resources/js/fluxkit.js` に `Alpine.data` として置き、Blade からは
  `x-data="名前(…)"` で呼ぶ（Blade の属性にアロー関数・メソッドを持つ `x-data="{ … }"` を書かない）
- 見た目は Tailwind v4 のクラス。使う側が `@source` で fluxkit のビューを拾う。部品固有の CSS は `resources/css/fluxkit.css`
- アプリごとに変える値は `config/fluxkit.php`（`page_sizes` など）。`App\…` やルート名を部品に持ち込まない

## 直して確かめる

テスト・リンター・ビルドの手順は無い。確かめるのはプレイグラウンドの画面だけ。

```bash
cd playground && docker compose up --build    # http://localhost:8095/fluxkit-preview
```

- `setup.sh` が `playground/app`（git に入れない）に Laravel を作り、このリポジトリを composer の path リポジトリで symlink する。
  作り直すときは `playground/app` を消して上げ直す
- プレビューは Livewire のコンポーネントの外なので `wire:click` は動かない。動きを見るなら `playground/app` に Livewire のコンポーネントを足す
- 部品を直すとそのまま画面に出る（`playground/README.md`）。部品を足したら `resources/views/preview.blade.php` にも足す
- **既定の見た目と props の名前は、使っているアプリ全部に効く。** 変えるなら利用者に確かめる

## 版を出す

1. `SKILL.md`（部品の一覧・props・例）・`CHANGELOG.md`・必要なら `lang/en.json` を同じコミットで直す
2. コミットして、版のタグを打って push（`git tag -a v0.1.2 -m v0.1.2 && git push origin main v0.1.2`）。
   既定の見た目や props を変えたら minor、足しただけ・直しだけなら patch
3. 使うアプリで `composer update cc9/fluxkit` して `composer.lock` を PR に入れる（そのアプリの PR の手順で）
4. 個人のスキルの写し（`~/.claude/skills/fluxkit/SKILL.md` と Windows の `C:\Users\<ユーザー>\.claude\skills\fluxkit\SKILL.md`）を写し直す

## Mac で作業するとき

- リポジトリは共有 SSD の `/Volumes/Satechi SSD/01_Active/fluxkit`。git・docker は Mac でそのまま走らせる
- Windows から触ると `._` ファイルができる。コミットの前に `git status` に出ていたら `dot_clean .` で消す

## Windows（デスクトップアプリ ＋ WSL2）で作業するとき

- リポジトリは WSL2 の `~/fluxkit`。**git・docker は WSL2 で走らせる**（Windows の git ではコミットしない。実行ビットが落ちる）。
  込み入ったコマンドは `/tmp/<日付>-<名前>.sh` に書いてから `MSYS_NO_PATHCONV=1 wsl.exe -d Ubuntu bash /tmp/…` で流す
- `playground/start.sh`・`setup.sh` を Edit・Write で書き換えたら、WSL で `chmod 755` に戻す。改行は LF

## どちらでも

- 作者は `nakano.kappei@gmail.com`（このリポジトリの git の設定。公開なので会社のアドレスを載せない）
- コミットメッセージは日本語。末尾に Co-Authored-By の行
