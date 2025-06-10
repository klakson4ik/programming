<div class="{{ $block }}">
	<h1 class="c-h1">{{ $page->title }}</h1>
	<section class="b-technology__slider c-section-margin">
		{!! $renderer->renderBlock('technology/technology-slider', [
			'technologies' => $technologies,
		]) !!}
	</section>
	<section class="b-technology__content">
		{!! $renderer->renderBlock('technology/technology-content', [
			'data' => $content,
		]) !!}
	</section>
	<section class="b-technology__trades">
		{!! $renderer->renderBlock('technology/technology-products', [
			'data' => $trades,
			'title' => $page->subtitle,
		]) !!}
	</section>
</div>