<div class="b-checkbox b-input">
	<div class="b-checkbox__container">
    <input class="checkbox"
		id="{{ $name }}"
		type="checkbox"
		@if ($required) required @endif
        name="{{ $name }}"
		{{ isset($checked) && $checked ? 'checked' : '' }}
        value="{{ isset($label) ? $label : '' }}">
    <label for="{{ $name }}">{!! $label ?? '' !!}</label>
	</div>
	<div class="field-error">
	</div>
</div>
