<div class="b-input">
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}" @if ($required) required @endif
        class="c-border-gray-light input
">
	<div class="field-error">
	</div>
</div>
