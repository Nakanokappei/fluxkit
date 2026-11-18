<?php

/*
 * fluxkit configuration. Keys written in the app's config/fluxkit.php override the same top-level keys here.
 */

return [

    // Choices for "Rows per page" in x-fluxkit::table-pager. Keep it the same list as the validation on the receiving (Livewire) side.
    'page_sizes' => [10, 25, 50, 100],

    // Preview listing every component (GET /{path}). Enabled only in development (APP_ENV=local).
    'preview' => [
        'enabled' => (bool) env('FLUXKIT_PREVIEW', env('APP_ENV') === 'local'),
        'path' => 'fluxkit-preview',
        'middleware' => ['web'],
        // Vite entry points loaded in the preview's <head>: the Tailwind CSS and the JS that registers fluxkit's JS.
        'vite' => ['resources/css/app.css', 'resources/js/app.js'],
    ],

];
