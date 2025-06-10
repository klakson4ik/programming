{!!
	$templates->renderBlock('partials/products-list', [
		'directions' => $directions,
		'products' => $products,
		'choiceFilters' => $choiceFilters,
		'directionIds' => $directionIds,
	])
!!}
