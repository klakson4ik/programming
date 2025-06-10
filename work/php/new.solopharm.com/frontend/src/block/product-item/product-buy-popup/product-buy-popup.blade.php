<div class="{{ $block }}">
	<div class="{{ $block->elem('links-container') }}">
		{!! file_get_contents('images/links-icons/background.svg') !!}
		@if($links['ozon'])
			<a
				href="{{ $links['ozon'] }}"
				class="{{ $block->elem('link')->mod('ozon') }}"
				target="_blank"
			>
				{!! file_get_contents('images/links-icons/ozon.svg') !!}
			</a>
		@endif
		@if($links['wb'])
			<a
				href="{{ $links['wb'] }}"
				class="{{ $block->elem('link')->mod('wb') }}"
				target="_blank"
			>
				{!! file_get_contents('images/links-icons/wildberries.svg') !!}
			</a>
		@endif
		@if($links['uteka'] !== "")
			<a
				href="https://uteka.ru"
				class="{{ $block->elem('link')->mod('uteka') }}"
				data-product-ids="{{ $links['uteka'] }}"
			>
				{!! file_get_contents('images/links-icons/uteka.svg') !!}
			</a>
		@endif
	</div>
	<button class="{{ $block->elem('links-button') }}">
		Купить
	</button>
</div>