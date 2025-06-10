<div class="{{ $block }}" data-code="{{ $data->url_slug }}">
	<a class="{{ $block->elem('top-row') }}" href="/{{ locale() . routeName() . '/' . $data->url_slug . '/' }}">
		<p class="{{ $block->elem('title') }}">
			{{ $data->title }}
		</p>
		@if($data->trade_vital || $data->vital)
			<p class="{{ $block->elem('vital') }}" data-descr="{{ __('pages.vital-description') }}">{{ __('pages.vital') }}{!! file_get_contents('images/icons/exclamate.svg') !!}</p>
		@endif
		<div class="{{ $block->elem('card-attributes') }}">
			@if($data->trade_soon || $data->soon)
				<p class="{{ $block->elem('attribute')->mod('soon') }}">{{ __('pages.soon') }}</p>
			@endif
			@if($data->otc)
				<p class="{{ $block->elem('attribute')->mod('otc') }}">{{ __('pages.otc-card') }}</p>
			@endif
			@if($data->recept)
				<p class="{{ $block->elem('attribute')->mod('recept') }}">{{ __('pages.recept-card') }}</p>
			@endif
			@if($data->novelty)
				<p class="{{ $block->elem('attribute')->mod('novelty') }}">{{ __('pages.novelty-card') }}</p>
			@endif
		</div>
	</a>
	<div class="{{ $block->elem('img') }}">
		<div class="{{ $block->elem('pics-wrapper') }}">
			@foreach($data->trades as $trade)
				<a class="{{ $block->elem('trade-link') }}" href="/{{ locale() . routeName() . '/' . $data->url_slug . '/' . $trade->url_slug }}">
					<img
						src="{{ (isset($trade->img) ? '/storage/' . $trade->img  : '/images/s-empty.webp') }}"
						class="{{ $block->elem('trade-pic') }}"
						alt="{{ __('pages.photo') . ' ' . __('pages.product.img.alt-start') . ' ' .  $data->title . ' - Solopharm' }}"
						title="{{ __('pages.product.img.alt-start') . ' ' . $data->title . ' - Solopharm' }}"
					>
				</a>
			@endforeach
		</div>
		<div class="{{ $block->elem('pic-controller')->mod('prev') }}">
			{!! file_get_contents('images/icons/arrow-short.svg') !!}
		</div>
		<div class="{{ $block->elem('pic-controller')->mod('next') }}">
			{!! file_get_contents('images/icons/arrow-short.svg') !!}
		</div>
		<div class="{{ $block->elem('pagination') }}"></div>
	</div>
	@if ($data->CE || $data->export)
		<div class="{{ $block->elem('info')->mod(!$data->export ? 'end' : '') }}">
			@if ($data->export)
				<p class="{{ $block->elem('info-item') }}">{{ __('pages.export') }}<span>*<span></p>
			@endif
			@if ($data->CE)
				<p class="{{ $block->elem('info-item') }}">СЕ</p>
			@endif
		</div>
	@endif
	</div>
