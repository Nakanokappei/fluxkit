{{--
    A badge carrying a user-given name, such as a department or a label. Flux's badge is whitespace-nowrap and
    never wraps, so a long name pushes rows and columns wider. This caps the width, truncates the overflow
    with …, and shows the full name in title.

        <x-fluxkit::name-badge :name="$team->name" color="blue" />
        <x-fluxkit::name-badge :name="$tag['name']" :title="$tag['note']" color="sky" />

      name     The name to show
      title    Text shown on hover. Defaults to name (shown even when not truncated)
      max      Tailwind class for the max width. Defaults to max-w-48 (12rem). Write the class literally
               when changing it (Tailwind only picks up literal classes in views)
      color, variant, icon  Passed straight to flux:badge

    Other attributes (class, style, data-test) also go on the badge. size is fixed to sm. Where badges sit side
    by side and must not shrink when the row gets tight, pass class="shrink-0". Do not use it for badges with
    short, fixed wording such as roles or states (keep flux:badge for those).
--}}
@props(['name', 'title' => null, 'max' => 'max-w-48', 'color' => null, 'variant' => null, 'icon' => null])

<flux:badge size="sm" :color="$color" :variant="$variant" :icon="$icon"
    :attributes="$attributes->merge(['title' => $title ?? $name])->class(['min-w-0', $max])">
    <span class="truncate">{{ $name }}</span>
</flux:badge>
