<?php

namespace App\Services\Forms\Fields;

use TAO;

class Select extends AbstractField
{
	private array $items;
	private string $noOneLabel;
	private string $ariaLabel;
	private bool $widthSearch;

	public function __construct(string $name, string $label, array $params = [])
	{
		parent::__construct($name, $label, $params);

		$this->items = $params['items'];
		$this->noOneLabel = $params['noOneLabel'] ?? 'Не выбрано';
		$this->ariaLabel = $params['ariaLabel'] ?? '';
		$this->widthSearch = $params['widthSearch'] ?? false;
	}

	public function render(): string
	{
		$search = '';

		if ($this->widthSearch) {
			$search = TAO::frontend()->renderBlock('fields/input-search', [
				'placeholder' => 'Найти',
				'name' => 'search',
				'label_mod' => ['spaceless-x', 'border-b']
			]);
		}

		return TAO::frontend()->renderBlock('fields/select', [
			'name' => $this->name,
			'required' => $this->required,
			'label' => $this->label,
			'items' => $this->items,
			'id' => $this->id,
			'mod' => $this->mod,
			'ariaLabel' => $this->ariaLabel,
			'noOneLabel' => $this->noOneLabel,
			'search' => $search,
		]);
	}
}