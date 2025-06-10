<div class="{{ $block->mod($mod ?? '') }}">
	@foreach ($items as $item)
		<div class="{{ $block->elem('item') }}">
			@if ($item['title'])
				<div class="{{ $block->elem('header') }} c-h2">
					{{ $item['title'] }}
				</div>
			@endif

			@if ($item['value'])
				<p class="{{ $block->elem('desc') }}">
					{{ $item['value'] }}
				</p>
			@endif

		</div>
	@endforeach
</div>