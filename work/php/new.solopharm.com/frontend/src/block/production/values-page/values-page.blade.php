<div class="{{ $block }}">
	{!! $renderer->renderBlock('production/production-header-values', [
		'pageData' => $pageData,
	]) !!}
	 {!! $renderer->renderBlock('production/production-youtube', [
		'page' => $pageData,
	]) !!}
	<h2 class="c-h2">{{ $pageData->block_1_title}}</h2>
	{!! $renderer->renderBlock('production/production-slider-block', [
		'chronology' => $chronology,
	]) !!}
	{!! $renderer->renderBlock('production/production-solnow-verslider', [
		'pageData' => $pageData,
		'achievement' => $achievement,
	]) !!}
	{!! $renderer->renderBlock('production/production-solnow-right-verslider', [
		'pageData' => $pageData,
		'achievement' => $progress,
	]) !!}
	{!! $renderer->renderBlock('production/production-countries', [
		'pageData' => $pageData,
		'countriesBlock' => $renderer->renderBlock('countries/countries-map', [
			'items' => $country,
			'title' => $pageData->block_4_title,
		]),
	]) !!}
	{!! $renderer->renderBlock('production/production-solnow-value-block', [
		'pageData' => $pageData,
		'today' => $today,
	]) !!}
</div>