<div class="{{ $block }} active">
	<div class="{{ $block->elem('popup-container') }}">
		<div class="{{ $block->elem('row') }}">
			{!! $markIcon !!}
			<p class="{{ $block->elem('text') }}">
				{!! __('pages.main.popup') !!}
			</p>
		</div>
		<a class="{{ $block->elem('learn-link') }} b-button" href="{{ $link }}">
			{!! __('pages.main.learn') !!}
		</a>
		<button class="{{ $block->elem('cross') }}">
			{!! $crossIcon !!}
		</button>
	</div>
</div>