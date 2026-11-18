// Playground JS. Registers fluxkit's components (x-data) with the Alpine bundled in Livewire.
import { registerFluxkitComponents } from '../../../../resources/js/fluxkit.js';

document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
