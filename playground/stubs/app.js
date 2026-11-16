// プレイグラウンドの JS。Livewire が持つ Alpine に fluxkit の部品 (x-data) を登録する。
import { registerFluxkitComponents } from '../../../../resources/js/fluxkit.js';

document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
