<div class="{{ $block }} {{ $reverse ? 'reverse' : '' }}">
	<a target="_blank" href="{{ '/storage/' . $item->file }}" class="{{ $block->elem('link') }}">
		<div class="{{ $block->elem('title') }}">
			{{ $item->title }}
		</div>

		<div class="{{ $block->elem('desc') }}">
			{!! $item->desc !!}
		</div>

		<div class="{{ $block->elem('footer') }}">
			<div class="{{ $block->elem('status') }}">
				{{ $item->text }}
			</div>

			<div class="{{ $block->elem('date') }}">
				{{ $item->formatted_date }}
			</div>
		</div>
	</a>
	<div class="{{ $block->elem('text-container') }}">
		<div class="{{ $block->elem('text') }}">
			{!! $item->additional_text !!}
		</div>
	</div>
</div>