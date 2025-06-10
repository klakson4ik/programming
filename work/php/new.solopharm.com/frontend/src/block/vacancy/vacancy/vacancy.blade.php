<div class="{{ $block }}">
	<h1 class="c-h1">{!! $page->title !!}</h1>
	<section class="{{ $block->elem('row-top') }} c-section-margin">
		<div class="{{ $block->elem('column') }}">
			<img src="/storage/{{ $page->block_1_img }}" alt="{!! $page->title !!}" title="{!! $page->title !!}" />
			<img src="/images/icons/s-white.svg" />
		</div>
		<div class="{{ $block->elem('column')->mod('right') }}">
			<div>
				<p class="{{ $block->elem('column-title') }}">
					{!! $page->block_1_title !!}
				</p>
				<p class="{{ $block->elem('column-desc') }}">
					{!! $page->block_1_desc !!}
				</p>
			</div>
			@isset($page->block_1_url)
				<a class="{{ $block->elem('column-hh') }}" href="{{ $page->block_1_url }}" target="_blank">
					<p class="{{ $block->elem('column-hh-text') }}">
						{!! $renderer->renderBlock('common/icon', [
							'sprite' => 'share',
							'icon' => 'hh',
						]) !!}
						{{ $page->block_1_caption }}
						{!! $renderer->renderBlock('common/icon', [
							'icon' => 'arrow-right',
						]) !!}
					</p>
				</a>
			@endisset
		</div>
	</section>
	@if(isset($vacancies) && $vacancies)
		<h2 class="c-h2"> {{ $page->block_2_title }}</h2>
		<nav class="{{ $block->elem('menu') }}">
			<ul class="{{ $block->elem('menu-list') }}">
				<li class="{{ $block->elem('menu-item') }}">
					<button name="Санкт-Петербург" class="{{ $block->elem('menu-btn')->mod('active') }}">
						Санкт-Петербург <span class="{{ $block->elem('menu-btn-count')}}">{{ $counts['Санкт-Петербург']}}</span></button>
				</li>
				<li class="{{ $block->elem('menu-item') }}">
					<button name="Другие" class="{{ $block->elem('menu-btn') }}">
						Другие регионы <span class="{{ $block->elem('menu-btn-count')}}">{{ $counts['Другие']}}</span></button>
				</li>
			</ul>
		</nav>
		<section class="{{ $block->elem('row-middle') }} c-section-margin">
			{!! $renderer->renderBlock('vacancy/vacancy-list', [
				'vacancies' => $vacancies,
			]) !!}
		</section>
	@endif
	<div class="{{ $block->elem('bottom') }}">
		{!! $renderer->renderBlock('vacancy/vacancy-end', [
			'page' => $page,
		]) !!}
	</div>
</div>
