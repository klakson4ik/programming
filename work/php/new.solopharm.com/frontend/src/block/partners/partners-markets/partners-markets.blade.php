<div class="{{ $block }}">
	<h1 class="c-h1">{{ $header }}</h1>

	<div class="{{ $block->elem('container') }}">
		<div class="{{ $block->elem('content') }}">
			{!! $renderer->renderBlock('partners/partners-content', [
				'content' => $data['content'],
				'statistics' => $renderer->renderBlock('partners/partners-list', [
					'items' => $data['statistics'],
				]),
			]) !!}
		</div>

		<div class="{{ $block->elem('countries-map') }}">
			{!! $renderer->renderBlock('countries/countries-map', [
				'items' => $countries,
				'mod' => 'full',
				'title' => '',
			]) !!}
		</div>

		<div class="{{ $block->elem('find') }}">
			{!! $renderer->renderBlock('partners/partners-find', [
				'title' => $partnersData['title'],
				'content' => $partnersData['content'],
				'image' => $partnersData['image'],
				'email' => $renderer->renderBlock('common/button', [
					'type' => 'link',
					'url' => $partnersData['email']['address'],
					'text' => $partnersData['email']['text'],
					'icon' => 'arrow-long',
				]),
			]) !!}
		</div>
	</div>
</div>