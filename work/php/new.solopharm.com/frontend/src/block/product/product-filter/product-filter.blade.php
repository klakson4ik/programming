<form class="{{ $block }}" action="" method="get">
	<input class="{{ $block->elem('search') }}" type="text" name="search" placeholder="{{ __('pages.search') }}"
		   value="{{ Request::query('search') ?: '' }}">
	<ul class="{{ $block->elem('filters') }}">
		@if (!$directions->isEmpty())
			@foreach ($directions as $index => $item)
				@if($item['parent_id'] == 0)
					<li class="{{ $block->elem('item') }}">
						@if(!$item['children'])
							{!! $renderer->renderBlock('product/checkbox', [
								'name' => $item->url_slug,
								'id' => 'direction-' . $item->id . (isset($mobile) ? '-m' : ''),
								'text' => $item->name,
								'checked' =>
									$directionIds && in_array($item->id, $directionIds) ? true : false,
							]) !!}
						@else
							{!! $renderer->renderBlock('product/checkbox', [
								'name' => $item->url_slug,
								'id' => 'direction-' . $item->id . (isset($mobile) ? '-m' : ''),
								'text' => $item->name,
								'mod' => 'parent',
								'checked' =>
									$directionIds && in_array($item->id, $directionIds) ? true : false,
							]) !!}
							<div class="{{ $block->elem('dropdown-container') }}">
								<ul class="{{ $block->elem('dropdown-list') }}">
									@foreach($item['children'] as $child)
										<li class="{{ $block->elem('dropdown-item') }}">
											{!! $renderer->renderBlock('product/checkbox', [
												'name' => $directions[$child]->url_slug,
												'id' => 'direction-' . $directions[$child]->id . (isset($mobile) ? '-m' : ''),
												'text' => $directions[$child]->name,
												'checked' => $directionIds && in_array($directions[$child]->id, $directionIds) ? true : false,
											]) !!}
										</li>
									@endforeach
								</ul>
							</div>
						@endif
					</li>
				@endif
			@endforeach
		@endif
	</ul>
	<div class="{{ $block->elem('btns') }}">
		{!! $renderer->renderBlock('common/button', [
			'type' => 'button',
			'name' => 'reset',
			'text' => __('pages.reset'),
		]) !!}
		@isset($mobile)
			{!! $renderer->renderBlock('common/button', [
				'type' => 'button',
				'name' => 'find',
				'text' => __('pages.find'),
			]) !!}
		@endisset
	</div>
	<ul class="{{ $block->elem('additional-fields') }}">
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox', [
			'name' => 'novelty',
			'id' => 'novelty' . (isset($mobile) ? '-m' : ''),
			'text' => __('pages.novelty'),
			'checked' => isset($choiceFilters['novelty']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}">{!! $renderer->renderBlock('product/checkbox', [
			'name' => 'export',
			'id' => 'export' . (isset($mobile) ? '-m' : ''),
			'text' => __('pages.export'),
			'checked' => isset($choiceFilters['export']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox', [
			'name' => 'otc',
			'id' => 'otc' . (isset($mobile) ? '-m' : ''),
			'text' => __('pages.otc'),
			'checked' => isset($choiceFilters['otc']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox', [
			'name' => 'recept',
			'id' => 'recept' . (isset($mobile) ? '-m' : ''),
			'text' => __('pages.recept'),
			'checked' => isset($choiceFilters['recept']) ? true : false,
		]) !!}
		</li>
	</ul>
	<p class="{{ $block->elem('info')->mod('export') }}">
		<span>*</span><strong>{{ __('pages.export') }}</strong> - {{ __('pages.export-description') }}
	</p>
	@if (isset($page->file_1) || isset($page->file_2))
		<div class="{{ $block->elem('catalog-doc') }}">
			@isset($page->file_1)
				<a href="/storage/{{ $page->file_1 }}" target="_blank" class="{{ $block->elem('catalog-doc-item') }}">
					{{ $page->file_1_name ?? __('pages.product.catalog-default-name') }}

				</a>
			@endisset
			@isset($page->file_2)
				<a href="/storage/{{ $page->file_2 }}" target="_blank" class="{{ $block->elem('catalog-doc-item') }}">
					{{ $page->file_2_name ?? __('pages.product.catalog-default-name') }}
				</a>
			@endisset
		</div>
	@endif
</form>
