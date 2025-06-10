@php
    foreach ($items as &$el) {
        $el['name'] = $el['name'] ?? $name;
        $el['mods'] = $el['mods'] ?? $checkbox_mods;
        $el['id'] = $el['id'] ?? $name . '-' . $el['value'];
        if ($disabled) {
            $el['disabled'] = true;
        }
    }
@endphp
<div class="b-checkbox-group @if ($mods) {{ implode(' ', $mods) }} @endif"
	name="{{ $name }}"
    @if ($required) required @endif @if ($disabled) disabled @endif>
    @if ($label)
        <label class="b-checkbox-group__label">
            {{ $label }}
		</label>
    @endif
    <fieldset class="b-checkbox-group__list">
        @foreach ($items as $item)
            <div class="b-checkbox-group__item">
                {!! \TAO::frontend()->renderBlock('fields/checkbox', $item) !!}
                {{-- @include('fields/checkbox', $item) --}}
            </div>
        @endforeach
    </fieldset>
</div>
