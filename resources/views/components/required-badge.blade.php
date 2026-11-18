{{-- The "Required" badge for a required field. Place it inside a plain <label>.

    With flux:label, pass `:badge` instead (Flux draws the same look). Use this component, after the label text,
    only when flux:label cannot be used, such as with a plain <select>. The look matches flux:label's badge.
    Screen readers rely on the field's aria-required="true", so this is aria-hidden (so it is not read twice;
    Flux does the same).

        <label for="x">{{ $label }} <x-fluxkit::required-badge /></label>
        <select id="x" aria-required="true">…</select>
--}}
<span class="ms-1.5 text-zinc-800/70 text-xs font-medium bg-zinc-800/5 px-1.5 py-1 -my-1 rounded-[4px]" aria-hidden="true">{{ __('Required') }}</span>
