@php
	$prodIds = [];
@endphp

<div class="{{ $block }} c-container" data-lang="{!! app()->getLocale() !!}">
	<div class="{{ $block->elem('header') }}">
		<h2 class="c-h1">{{ $title }}</h2>
		<a href="{{ $linkUrl }}" class="{{ $block->elem('link') }} c-link-main">
			<span class="{{ $block->elem('header-link') }}">{{ $linkText }}</span><img src="/images/icons/arr-r.svg"
				alt=""></a>
		</a>
	</div>
	<div class="{{ $block->elem('list') }}">
		<ul>
			@foreach ($block4 as $item)
				<li onclick="HideDir('{{ $item->id }}', this);">
					{{ $item->name }}
				</li>
			@endforeach
		</ul>
	</div>
	<div class="{{ $block->elem('slider') }}">
		<div class="dir-slider-mobile {{ $block->elem('list-mobile') }}">
			<div class="swiper-wrapper">
				@foreach ($block4 as $item)
					<span class="c-h2 swiper-slide" data-dir="{{ $item->id }}">
						{{ $item->name }}
					</span>
				@endforeach
			</div>
		</div>
		<div class="dir-slider">
			<div class="swiper-wrapper swiper-wrapper-catalog">
			</div>
		</div>
		<div class="nav-dir">
		</div>
		<div class="arrows">
			<div class="arrow arrow-left">
				{!! $renderer->renderBlock('common/arrow', [
					'left' => true,
					'url' => '',
				]) !!}
			</div>
			<div class="arrow arrow-right">
				{!! $renderer->renderBlock('common/arrow', [
					'url' => '',
				]) !!}
			</div>
		</div>
	</div>
</div>
