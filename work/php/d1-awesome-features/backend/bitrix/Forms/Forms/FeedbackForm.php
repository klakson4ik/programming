<?php

namespace App\Services\Forms\Forms;

use App\Services\BitrixSupport\BitrixSupportService;
use App\Services\Forms\Fields\AbstractField;
use App\Services\Forms\Fields\Accept;
use App\Services\Forms\Fields\Email;
use App\Services\Forms\Fields\File;
use App\Services\Forms\Fields\Input;
use App\Services\Forms\Fields\Phone;
use App\Services\Forms\Fields\Rating;
use App\Services\Forms\Fields\Select;
use App\Services\Forms\Fields\Submit;
use App\Services\Forms\Fields\Textarea;
use App\Services\Forms\Storages\BitrixSupportStorage;
use TAO;

final class FeedbackForm extends AbstractForm
{
	public const ACTION = '/forms/feedback/';

	protected string $method = 'POST';
	protected string $form_html_id = 'feedback-form';
	private ?int $tickedId = null;

	public function __construct()
	{
		parent::__construct();

		$this->storages = [
			new BitrixSupportStorage($this->tickedId)
		];
	}

	public function getTicketId(): int
	{
		return (int)$this->tickedId;
	}

	public function renderForm(): string
	{
		$fields = array_map(
			static fn(AbstractField $field) => [
				'field' => $field->render(),
				'mod' => $field->form_mod
			],
			$this->getFields()
		);

		return TAO::frontend()->renderBlock('forms/feedback-form', [
			'fields' => $fields,
			'method' => $this->method,
			'action' => self::ACTION
		]);
	}

	protected function getFields(): array
	{
		return [
			new Select('category_id', 'Тема не выбрана', [
				'items' => array_map(
					static function(array $item) {
						return ['label' => $item['NAME'], 'value' => $item['ID']];
					},
					BitrixSupportService::instance()->dictionary->getCategoryDictionary()
				),
				'form_id' => $this->form_html_id,
				'required' => true,
				'ariaLabel' => 'Тема'
			]),
			new Input('name', 'Имя', [
				'form_id' => $this->form_html_id,
				'required' => true
			]),
			new Phone('phone', 'Номер телефона', [
				'form_id' => $this->form_html_id,
				'required' => true
			]),
			new Email('email', 'E-mail', [
				'form_id' => $this->form_html_id,
				'required' => true
			]),
			new Textarea('message', 'Сообщение', [
				'form_id' => $this->form_html_id,
				'required' => true
			]),
			new File('files', params: [
				'multiple' => true,
				'form_id' => $this->form_html_id,
				'accept' => ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'pdf']
			]),
			new Rating('rating', 'Оценка магазина:', [
				'required' => true
			]),
			new Accept(),
			new Submit()
		];
	}
}