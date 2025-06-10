<div class="{{ $block }} b-field">
	@isset($label)
		<label class="{{ $block->elem('label') }}" for="{{ $id ?? $name }}">{!! $label !!}{!! isset($required) ? ' <span class="' . $block->elem('label-required') . '">*</span>' : '' !!}</label>
	@endisset
	<div class="{{ $block->elem('input-container')->mod($type ?? '') }}" {{ isset($before) ? 'data-before=' . $before : '' }}>
		<input class="{{ $block->elem('field') }}" id="{{ $id ?? $name }}"
			type="{{ $type ?? 'text' }}" name="{{ $name ?? '' }}"
			value="{{ $value ?? '' }}" {{ isset($required) ? 'data-required=true' : '' }}
			@isset($pattern)
				data-pattern="{{ $pattern }}"
			@endisset
			@isset($accept)
				accept="{{ $accept }}"
			@endisset
			placeholder="{{ $placeholder ?? '' }}">
		@if(isset($type) && $type == 'file')
			<label class="{{ $block->elem('file-icon') }}" for="{{ $name ?? '' }}">
				{!! file_get_contents('images/icons/paper-clip.svg') !!}
			</label>
		@endif
	</div>
	@if (isset($errors) || isset($required))
		<div class="{{ $block->elem('validate') }}">
			@isset($errors)
				<div class="errors">
					@foreach ($errors as $key => $error)
						<p class="{{ $block->elem($key) }}">{!! $error !!}</p>
					@endforeach
				</div>
			@endisset
			@if(isset($required) && !isset($errors))
				<p class="required">{!! __('form.errors.required') !!}</p>
			@endif
		</div>
	@endif
</div>
