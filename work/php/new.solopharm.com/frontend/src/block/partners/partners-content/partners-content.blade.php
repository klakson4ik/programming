<div class="{{ $block->mod($mod ?? '') }}">
	@isset($content)
		<div class="{{ $block->elem('content') }}">
			{!! $content !!}
		</div>
	@endisset

	@isset($image)
		<div class="{{ $block->elem('image') }}">
			<img src="{{ $image }}" alt="">
		</div>
	@endisset

	@isset($statistics)
		<div class="{{ $block->elem('statistic') }}">
			{!! $statistics !!}
		</div>
	@endisset

</div>