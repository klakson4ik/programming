@foreach($pages as $items)
	<div class="{{ $block->elem('slide') }} swiper-slide">
		@foreach($items as $item)
			<div class="{{ $block->elem('product-card') }} block" data-code="{{ $item['url_slug'] }}">
				<div class="{{ $block->elem('top-row') }}">
					<a
						class="{{ $block->elem('title') }}"
						href="{{ (locale() ? '/' . locale() : '') . 'products/' . $item['url_slug'] }}"
					>
						{!! $item['title'] !!}
					</a>
					@if($item['vital'])
						<p
							class="vital"
							data-descr="Включен в перечень жизненно необходимых и важнейших лекарственных препаратов"
						>
							{{ __('pages.vital') }}{!! $svgExclamate !!}
						</p>
					@endif
					<div class="{{ $block->elem('card-attributes') }}">
						@if($item['soon'])
							<p class="{{ $block->elem('attribute')->mod('soon') }}">
								{{ __('pages.soon') }}
							</p>
						@endif
						@if($item['otc'])
							<p class="{{ $block->elem('attribute')->mod('otc') }}">
								{{ __('pages.otc-card') }}
							</p>
						@endif
						@if($item['recept'])
							<p class="{{ $block->elem('attribute')->mod('recept') }}">
								{{ __('pages.recept-card') }}
							</p>
						@endif
						@if($item['novelty'])
							<p class="{{ $block->elem('attribute')->mod('novelty') }}">
								{{ __('pages.novelty-card') }}
							</p>
						@endif
					</div>
				</div>
				<div class="{{ $block->elem('img') }}">
					<div class="{{ $block->elem('wrapper') }}">
						@if(is_array($item['trades']) && count($item['trades']) > 0)
							@foreach($item['trades'] as $trade)
								<a
									class="{{ $block->elem('trade-link') }}"
									href="/{{ locale() . 'products/' . $item['url_slug'] . '/' . $trade->url_slug }}"
								>
									<img
										title="{{ $trade->form }}"
										alt="Фото {{ $trade->form }}"
										src="{{ $trade->img ? '/storage/' . $trade->img : '/images/s-empty.webp' }}"
									/>
								</a>
							@endforeach
						@else
							<a
								class="{{ $block->elem('trade-link') }}"
								href="/{{ locale() . 'products/' . $item['url_slug'] }}"
							>
								<img
									title="{{ $item['title'] }}"
									alt="Фото {{ $item['title'] }}"
									src="/images/s-empty.webp"
								/>
							</a>
						@endif
					</div>
					<div class="{{ $block->elem('pic-controller')->mod(['prev', 'locked']) }}">{!! $svgArrow !!}</div>
					<div class="{{ $block->elem('pic-controller')->mod(['next', 'locked']) }}">{!! $svgArrow !!}</div>
					<div class="{{ $block->elem('pagination') }}"></div>
				</div>
				<div class="{{ $block->elem('item-bottom') }}">
					<p class="{{ $block->elem('bottom')->mod('left') }}">{{ $item['export'] ? __('pages.export') : '' }}</p>
					<p class="{{ $block->elem('bottom')->mod('right') }}">{{ $item['CE'] ? 'CE' : '' }}</p>
				</div>
			</div>
		@endforeach
	</div>
@endforeach