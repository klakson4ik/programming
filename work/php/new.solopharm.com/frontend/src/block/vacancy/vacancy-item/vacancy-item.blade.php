<div class="{{ $block }}">
	<section class="{{ $block->elem('content') }} c-border-bottom">
		<div class="{{ $block->elem('column') }}">
			<div class="{{ $block->elem('dynamic') }}">
				<div class="{{ $block->elem('dynamic-top') }}">
					<h1 class="{{ $block->elem('dynamic-top-title')}} c-h1">{!! $vacancy->title !!}</h1>
					{!! $renderer->renderBlock('common/button', [
						'text' => __('pages.respond.caption'),
						'url' => $respond,
						'icon' => 'arrow-long',
					]) !!}
				</div>
				<div class="{{ $block->elem('dynamic-bottom') }}">
					{!! $renderer->renderBlock('partials/social-share/social-share-btn', [
						'socialShare' => $socialShare,
					]) !!}
				</div>
			</div>
		</div>
		<div class="{{ $block->elem('column')->mod('desc') }}">
				@isset ($vacancy->description)
				{!! $vacancy->description !!}
				@endisset
		</div>
		<div class="{{ $block->elem('social-mobile') }}">
			{!! $renderer->renderBlock('partials/social-share/social-share-btn', [
				'socialShare' => $socialShare,
			]) !!}
		</div>
	</section>
	<div class="{{ $block->elem('bottom') }}">
		{!! $renderer->renderBlock('vacancy/vacancy-end', [
			'page' => $page,
		]) !!}
	</div>
</div>
