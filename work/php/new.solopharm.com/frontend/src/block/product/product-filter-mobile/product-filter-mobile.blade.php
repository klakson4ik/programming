<div class="{{ $block }}">
	<ul class="{{ $block->elem('filters') }} c-container">
		<li class="{{ $block->elem('item') }}">
			<div class="{{ $block->elem('header') }}">
				<p class="{{ $block->elem('header-title') }}">{{ __('pages.product.filter.name') }}</p>
				<button class="{{ $block->elem('close') }}">{{ __('pages.product.filter.back') }}</button>
			</div>
		</li>
		@if (!$directions->isEmpty())
			@foreach ($directions as $item)
				@if($item['parent_id'] == 0)
					<li class="{{ $block->elem('item') }}">
						@if(!$item['children'])
							{!! $renderer->renderBlock('product/checkbox-mobile', [
								'name' => $item->url_slug,
								'id' => 'direction-' . $item->id . (isset($mobile) ? '-m' : ''),
								'text' => $item->name,
								'checked' =>
									$directionIds && in_array($item->id, $directionIds) ? true : false,
							]) !!}
						@else
							{!! $renderer->renderBlock('product/checkbox-mobile', [
								'name' => $item->url_slug,
								'id' => 'direction-' . $item->id . (isset($mobile) ? '-m' : ''),
								'text' => $item->name,
								'checked' =>
									count($item->children) == count(array_filter($item->children,
										function($value) use ($directions, $choiceFilters) {
											if(!isset($directionIds) || !$directionIds) return false;
											return in_array($directions[$value]['id'], $directionIds);
										})) ? true : false,
								'parent' => true,

							]) !!}
							<div class="{{ $block->elem('dropdown-container') }}">
								<ul class="{{ $block->elem('dropdown-list') }}">
									@foreach($item['children'] as $child)
										<li class="{{ $block->elem('dropdown-item') }}">
											{!! $renderer->renderBlock('product/checkbox-mobile', [
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
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox-mobile', [
			'name' => 'novelty',
			'id' => 'novelty' . (isset($mobile) ? '-m' : ''),
			'mod' => 'bool',
			'text' => __('pages.novelty'),
			'checked' => isset($choiceFilters['novelty']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}">{!! $renderer->renderBlock('product/checkbox-mobile', [
			'name' => 'export',
			'id' => 'export' . (isset($mobile) ? '-m' : ''),
			'mod' => 'bool',
			'text' => __('pages.export'),
			'checked' => isset($choiceFilters['export']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox-mobile', [
			'name' => 'otc',
			'id' => 'otc' . (isset($mobile) ? '-m' : ''),
			'mod' => 'bool',
			'text' => __('pages.otc'),
			'checked' => isset($choiceFilters['otc']) ? true : false,
		]) !!}
		</li>
		<li class="{{ $block->elem('item') }}"> {!! $renderer->renderBlock('product/checkbox-mobile', [
			'name' => 'recept',
			'id' => 'recept' . (isset($mobile) ? '-m' : ''),
			'mod' => 'bool',
			'text' => __('pages.recept'),
			'checked' => isset($choiceFilters['recept']) ? true : false,
		]) !!}
		</li>
	</ul>
</div>
