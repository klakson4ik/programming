<div class="{{ $block }}">
	<div class="{{ $block->elem('container') }}">
		<h2 class="{{ $block->elem('header') }} c-h2">
			{{ $title }}
		</h2>

		<div class="{{ $block->elem('content') }}">
			{!! $content !!}
		</div>

		<div class="{{ $block->elem('email') }}">
			{!! $email !!}
		</div>
	</div>

	<div class="{{ $block->elem('image') }}">
		<img src="{{ $image }}" alt="{{ $title }}">
	</div>
</div>