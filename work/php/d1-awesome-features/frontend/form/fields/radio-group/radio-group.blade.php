<div class="b-radio-group @if ($mods) {{ implode(' ', $mods) }} @endif"
	name="{{ $name }}"
	@if ($required) required @endif>
    @if ($label)
        <label class="b-radio-group__label">
            {{ $label }}
        </label>
    @endif
    <fieldset class="b-radio-group__list">
        @foreach ($items as $item)
            <div class="b-radio @if ($radio_mods) {{ implode(' ', $radio_mods) }} @endif">
                <input class="b-radio__input"
					type="radio" name="{{ $name }}"
					value="{{ $item['value'] }}"
                    id="{{ $id ?? $name . '-' . $item['value'] }}"
                    @if ($item['disabled']) disabled @endif
					@if ($item['checked']) checked @endif>
                <label for="{{ $id ?? $name . '-' . $item['value'] }}" class="b-radio__label">
                    {!! $item['label'] !!}
                </label>
            </div>
        @endforeach
    </fieldset>
</div>
