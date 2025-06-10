<div class="{{ $block }}">
	@if($currentTrade->pharm || $product->pharm)
		<div class="{{ $block->elem('pharm') }}">
			<p class="{{ $block->elem('title') }}">
				@if(
					$product->category == 'dietary_supplements'
					||
					$product->category == 'medical_device'
					||
					!$product->category
				)
					{!! __('pages.product.scope_pharm') !!}
				@else
					{!! __('pages.product.pharm') !!}
				@endif
			</p>
			<p>
				{!! $currentTrade->pharm ?? $product->pharm !!}
			</p>
		</div>
	@endif
	@if($currentTrade->compound || $product->compound)
		<div class="{{ $block->elem('compound') }}">
			<p class="{{ $block->elem('title') }}">
				@if(
					$product->category == 'dietary_supplements'
					||
					$product->category == 'medical_device'
					||
					!$product->category
				)
				{!! __('pages.product.compound') !!}
				@else
					{!! __('pages.product.MNN') !!}
				@endif
			</p>
			<p>
				{!! $currentTrade->compound ?? $product->compound !!}
			</p>
		</div>
	@endif
	@if ($trades->isNotEmpty())
		<div class="{{ $block->elem('trades') }}">
			@foreach ($trades as $item)
				<a href="/{{ locale() . routeName() . '/' . $product->url_slug . '/' . $item->url_slug }}"
					class="{{ $block->elem('trades-item')->mod($currentTrade->id == $item->id ? 'active' : '') }}">
					{!! $item->form !!}
				</a>
			@endforeach
		</div>
	@endif
	@if ($currentTrade->technology)
		<div class="{{ $block->elem('technology') }}">
			<p>
				{!! $currentTrade->technology->title !!}
			</p>
			<img src="/storage/{{ $currentTrade->technology->svg }}">
		</div>
	@endif
	@if ($product->CE || $currentTrade->export_countries)
		<div class="{{ $block->elem('export') }}">
			@if ($currentTrade->export_countries)
				<div class="{{ $block->elem('export-countries') }}">
					<p class="{{ $block->elem('title') }}">
						{{ __('pages.product.export_countries') }}
					</p>
					{!! $renderer->renderBlock('common/icon', [
						'icon' => 'arrow-middle',
					]) !!}
					<div class="{{ $block->elem('export-countries-items') }}">
						@foreach ($currentTrade->export_countries as $item)
							<p>
								{!! $item['value'] !!}
							</p>
						@endforeach
					</div>
				</div>
			@endif
			@if ($product->CE || $currentTrade->CE)
				{!! $renderer->renderBlock('common/icon', [
					'icon' => 'ce',
				]) !!}
			@endif
		</div>
	@endif
	@if(isset($links) && (count($links) > 0))
		{!! $renderer->renderBlock('product-item/product-buy-popup', [
			'links' => $links
		]) !!}
	@endif
	@if (isset($catalogPage->file_1) || isset($catalogPage->file_2))
		<div class="{{ $block->elem('catalog-doc') }}">
			@isset($catalogPage->file_1)
				<a href="/storage/{{ $catalogPage->file_1 }}" target="_blank" class="{{ $block->elem('catalog-doc-item') }}">
					{{ $catalogPage->file_1_name ?? __('pages.product.catalog-default-name') }}

				</a>
			@endisset
			@isset($catalogPage->file_2)
				<a href="/storage/{{ $catalogPage->file_2 }}" target="_blank" class="{{ $block->elem('catalog-doc-item') }}">
					{{ $catalogPage->file_2_name ?? __('pages.product.catalog-default-name') }}
				</a>
			@endisset
		</div>
	@endif
</div>
