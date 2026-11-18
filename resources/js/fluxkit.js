/*
 * Alpine components used by the fluxkit components (x-data="name(…)").
 *
 * The CSP build of Alpine (Livewire's config livewire.csp_safe) cannot read x-data="{ … }" with arrow functions,
 * if statements or methods inside Blade attributes. Such behavior lives here as Alpine.data, and components
 * refer to it by name. It works the same with the non-CSP Alpine.
 *
 * Call it once from the app's JS, before Alpine starts (alpine:init):
 *
 *     import { registerFluxkitComponents } from '../../vendor/cc9/fluxkit/resources/js/fluxkit.js';
 *     document.addEventListener('alpine:init', () => registerFluxkitComponents(window.Alpine));
 */
export function registerFluxkitComponents(Alpine) {
    Alpine.data('pageNavInput', pageNavInput);
}

/**
 * The page number field of a table (components/page-nav.blade.php). Clamps the typed number to 1..last page,
 * writes it back to the field, and if it differs from the current page, stores it in page and returns true
 * (the view then calls $wire.gotoPage(page, …)).
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
