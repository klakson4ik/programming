<?php

namespace App\Services\Forms\Fields;

class Content extends AbstractField
{
	private string $content;

	public function __construct(string $content)
	{
		parent::__construct('content', '', []);

		$this->content = $content;
	}

	public function render(): string
	{
		return $this->content;
	}
}