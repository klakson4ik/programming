<div class="b-input">
    @if ($label)
        <label id="{{ $id ?? $name }}" class="b-input__label">
            {{ $label }}
        </label>
    @endif
    <input class="b-input__field" type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $id ?? $name }}"
        value="{{ $value }}" autocomplete="{{ $autocomplete ?? 'on' }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($pattern) pattern="{{ $pattern }}" @endif
        @if ($required) required @endif @if ($disabled) disabled @endif
        @isset($min) min="{{ $min }}" @endisset
        @isset($max) max="{{ $max }}" @endisset
        @if ($attrs) @foreach ($attrs as $attr => $value)
					{{ $attr }}="{{ $value }}"
			@endforeach @endif
        @if ($props) @foreach ($props as $prop => $value)
				data-{{ $prop }}="{{ $value }}"
			@endforeach @endif>
</div>
