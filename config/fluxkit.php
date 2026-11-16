<?php

/*
 * fluxkit の設定。アプリの config/fluxkit.php に書いた鍵が、ここの同じ鍵 (いちばん上の段) を上書きする。
 */

return [

    // x-fluxkit::table-pager の「1 ページの行数」の選択肢。行数を受け取る側 (Livewire) の検証と同じ一覧を渡す。
    'page_sizes' => [10, 25, 50, 100],

    // 全部品を並べたプレビュー (GET /{path})。開発環境 (APP_ENV=local) でだけ開く。
    'preview' => [
        'enabled' => (bool) env('FLUXKIT_PREVIEW', env('APP_ENV') === 'local'),
        'path' => 'fluxkit-preview',
        'middleware' => ['web'],
        // プレビューの <head> で読む Vite の入口。Tailwind の CSS と、fluxkit の JS を登録する JS。
        'vite' => ['resources/css/app.css', 'resources/js/app.js'],
    ],

];
