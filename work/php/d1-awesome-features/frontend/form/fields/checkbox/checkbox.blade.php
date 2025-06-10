<div class="b-checkbox @if($mods) {{ implode(' ', $mods) }} @endif">
	<input
		class="b-checkbox__input"
		name="{{ $name }}"
		id="{{ $id ?? $name }}"
		value="{{ $value }}"
		@if ($checked) checked @endif
		@if ($required) required @endif
		@if ($disabled) disabled @endif
		type="checkbox"
	>
	<label for="{{ $id ?? $name }}" class="b-checkbox__label">
		{!! $label !!}
	</label>
</div>
