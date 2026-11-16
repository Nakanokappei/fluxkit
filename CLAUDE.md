# CLAUDE.md

fluxkit（`cc9/fluxkit`）で Claude Code が作業するときの指針。**日本語で書き、チャットの返答も日本語で**（識別子は英語）。

## これは何か

Livewire 4 ＋ Flux 2 の Laravel アプリで使う、無名の Blade コンポーネント集（`<x-fluxkit::card>` など 20 個）。
**公開リポジトリ**（github.com/Nakanokappei/fluxkit）。部品の一覧・props・使い方・守る決まりは **`SKILL.md`**（最初に読む）。

- **使っているアプリの業務の語・顧客名・URL・アカウント ID をここに書かない**（公開。コメントや例も同じ）
- 部品の頭のコメントの例に `__('…')` を書かない（使う側の訳のファイルの鍵の数え上げに拾われる。v0.1.1）

## 直して確かめる

```bash
cd playground && docker compose up --build    # http://localhost:8095/fluxkit-preview
```

- 部品を直すとそのまま画面に出る（`playground/README.md`）。部品を足したら `resources/views/preview.blade.php` にも足す
- **既定の見た目と props の名前は、使っているアプリ全部に効く。** 変えるなら利用者に確かめる

## 版を出す

1. `SKILL.md`（部品の一覧・props・例）・`CHANGELOG.md`・必要なら `lang/en.json` を同じコミットで直す
2. コミットして、版のタグを打って push（`git tag -a v0.1.2 -m v0.1.2 && git push origin main v0.1.2`）。
   既定の見た目や props を変えたら minor、足しただけ・直しだけなら patch
3. 使うアプリで `composer update cc9/fluxkit` して `composer.lock` を PR に入れる（voc-triage なら、その PR の手順で）
4. 個人のスキルの写し（`~/.claude/skills/fluxkit/SKILL.md` と Windows の `C:\Users\<ユーザー>\.claude\skills\fluxkit\SKILL.md`）を写し直す

## この PC（Windows のデスクトップアプリ ＋ WSL2）

- リポジトリは WSL2 の `~/fluxkit`。**git・docker は WSL2 で走らせる**（Windows の git ではコミットしない。実行ビットが落ちる）。
  込み入ったコマンドは `/tmp/<日付>-<名前>.sh` に書いてから `MSYS_NO_PATHCONV=1 wsl.exe -d Ubuntu bash /tmp/…` で流す
- 作者は `nakano.kappei@gmail.com`（このリポジトリの git の設定。公開なので会社のアドレスを載せない）
- `playground/start.sh`・`setup.sh` を Edit・Write で書き換えたら、WSL で `chmod 755` に戻す。改行は LF
- コミットメッセージは日本語。末尾に Co-Authored-By の行
