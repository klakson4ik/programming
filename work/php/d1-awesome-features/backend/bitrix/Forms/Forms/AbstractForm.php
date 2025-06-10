<?php

namespace App\Services\Forms\Forms;

use App\Services\Forms\Captcha\YandexCaptcha;
use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\CaptchaInterface;
use App\Services\Forms\Interfaces\StorageInterface;
use App\Services\Forms\Interfaces\ValidatorInterface;
use App\Services\Forms\Validators\Validator;
use App\Services\Mail\Mail;

abstract class AbstractForm
{
	public const FIELD_TOKEN = 'token';
	public const ACTION = '';

	protected string $name = '';
	protected string $method = '';
	protected bool $use_captcha = true;
	protected array $request = [];
	protected array $events = [];
	protected CaptchaInterface $captcha;
	protected ValidatorInterface $validator;

	/** @var StorageInterface[] */
	protected array $storages = [];

	public function __construct()
	{
		$this->captcha = new YandexCaptcha();
		$this->validator = new Validator();
	}

	/**
	 * @throws FormException
	 */
	public function process(array $request): void
	{
		$this->request = $request;

		$this->beforeProcess();
		$this->validate();
		$this->store();
		$this->sendEvents();
		$this->afterProcess();
	}

	protected function store(): void
	{
		foreach ($this->storages as $method => $storage) {
			$fields = (is_string($method) && method_exists($this, $method))
				? $this->{$method}()
				: $this->request;

			$storage->store($fields);
		}
	}

	protected function sendEvents(): void
	{
		Mail::sendEmailByEvents(
			$this->events,
			$this->fieldsForMailEvent()
		);
	}

	/**
	 * @throws FormException
	 */
	protected function validate(): void
	{
		if ($this->use_captcha && !isLocal()) {
			$this->captcha->verify($this->request[self::FIELD_TOKEN]);
		}

		$this->request = $this->validator
			->validate($this->request, $this->getFields())
			->getFields();
	}

	protected function fieldsForBitrixWebForm(): array
	{
		return $this->request;
	}

	protected function fieldsForMailEvent(): array
	{
		return $this->request;
	}

	protected function afterProcess(): void
	{
	}

	protected function beforeProcess(): void
	{
	}

	abstract public function renderForm(): string;

	abstract protected function getFields(): array;
}
