<?php

namespace App\Services\Forms\Fields;

use Elephox\Mimey\MimeTypes;
use TAO;

class File extends AbstractField
{
	public array $accept = [];
	public bool $multiple;

	public function __construct(string $name, string $label = 'Приложите файл', array $params = [])
	{
		parent::__construct($name, $label, $params);

		if ($params['accept']) {
			$this->accept = $this->createAccept($params['accept']);
		}

		$this->multiple = $params['multiple'] ?? false;
	}

	public function render(): string
	{
		return TAO::frontend()->renderBlock('fields/input-file', [
			'label' => $this->label,
			'name' => $this->name,
			'required' => $this->required,
			'id' => $this->id,
			'mod' => $this->mod,
			'multiple' => $this->multiple,
			'accept' => $this->accept
		]);
	}

	private function createAccept(array $extensions): array
	{
		return [
			'label' => implode(', ', $extensions),
			'attr' => implode(',', array_map('getMimeByExtension',	$extensions))
		];
	}
}