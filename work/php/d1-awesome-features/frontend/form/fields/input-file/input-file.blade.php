<div class="b-input-file @if ($mods) {{ implode(' ', $mods) }} @endif">
	<input class="b-input-file__input"
		type="file"
		name="{{ $name . ($multiple ? '[]' : '')}}"
		@if($multiple) multiple @endif
		@if($required) required @endif
		@if($accept) accept="{!! implode(', ', $accept) !!}" @endif
		@if ($props)
			@foreach ($props as $prop => $value)
				data-{{ $prop }}="{{ $value }}"
			@endforeach
		@endif
		>
	<button class="b-input-file__button">
		{!! $label !!}
	</button>
	@if ($props['max-file-size'])
		<span class="b-input-file__max-size">Маскимальный размер файла: {{ $props['max-file-size']}}Mb</span>
	@endif
	@if ($accept)
		<span class="b-input-file__max-size">Допустимые расширения: {!! implode(', ', $accept) !!} </span>
	@endif
</div>
