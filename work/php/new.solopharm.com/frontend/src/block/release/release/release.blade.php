<div class="{{ $block }}">
	<h1 class="c-h1">{{ $page->title }}</h1>
	@isset($forms)
		<section class="{{ $block->elem('items') }}">
			@foreach ($forms as $form)
				{!! $renderer->renderBlock('release/release-item', [
					'form' => $form,
				]) !!}
			@endforeach
		</section>
	@endisset
</div>