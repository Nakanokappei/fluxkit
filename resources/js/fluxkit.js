/*
 * fluxkit の部品が使う Alpine の部品 (x-data="名前(…)")。
 *
 * CSP 用の Alpine (Livewire の config livewire.csp_safe) は、Blade の属性の中のアロー関数・if 文・メソッドを持つ
 * x-data="{ … }" を読めない。そうした動きはここに Alpine.data として置き、部品からは名前で呼ぶ。
 * CSP 用でない Alpine でもそのまま動く。
 *
 * アプリの JS から、Alpine が始まる前 (alpine:init) に 1 回呼ぶ:
 *
 *     import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';
 *     document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
 */
export function registerFluxkitComponents(Alpine) {
    Alpine.data('pageNavInput', pageNavInput);
}

/**
 * 表のページ番号の欄 (components/page-nav.blade.php)。打った番号を 1〜最後のページに丸めて欄に書き戻し、
 * いまのページと違えば page に入れて true を返す (ビューが続けて $wire.gotoPage(page, …) を呼ぶ)。
 */
function pageNavInput(current, last) {
    return {
        page: current,
        pickPage() {
            const typed = parseInt(this.$el.value, 10);
            if (Number.isNaN(typed)) {
                this.$el.value = current;
                return false;
            }
            const page = Math.min(Math.max(typed, 1), last);
            this.$el.value = page;
            if (page === current) return false;
            this.page = page;
            return true;
        },
    };
}
