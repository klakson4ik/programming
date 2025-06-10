<div class="{{ $block }}">
	{!! $renderer->renderBlock('production/production-header-rnd', [
		'pageData' => $pageData,
	]) !!}

	{!! $renderer->renderBlock('production/production-img-block-rnd', [
		'pageData' => $pageData,
	]) !!}

	{!! $renderer->renderBlock('production/production-info-rnd', [
		'pageData' => $pageData,
	]) !!}
</div>