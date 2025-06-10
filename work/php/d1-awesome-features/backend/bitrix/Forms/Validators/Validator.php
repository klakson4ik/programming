<?php

namespace App\Services\Forms\Validators;

use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Fields\AbstractField;
use App\Services\Forms\Interfaces\ValidatorInterface;
use Bitrix\Main\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class Validator implements ValidatorInterface
{
	private string $locale;
	private array $fields;
	private Factory $factory;
	private Translator $translator;

	public function __construct(?string $locale = null)
	{
		$this->locale = $locale ?: Application::getInstance()->getContext()->getLanguage();
		$this->translator = $this->makeTranslator();
		$this->factory = new Factory($this->translator);
	}

	/**
	 * @param array $values
	 * @param AbstractField[] $fields
	 * @return $this
	 * @throws FormException
	 */
	public function validate(array $values, array $fields): static
	{
		$attributes = [];
		$messages = [];
		$errors = [];
		$validatorData = [];

		foreach ($fields as $field) {
			$value = $values[$field->name];
			$rules = is_string($field->validate) ? explode('|', $field->validate) : [];

			if ($field->store) {
				$this->fields[$field->name] = $value;
			}

			if ($field->validate_error_message) {
				$messages[$field->name] = $field->validate_error_message;
			}

			if ($field->label) {
				$attributes[$field->name] = $field->label;
			}

			if (is_callable($field->validate)) {
				$validateResult = call_user_func_array($field->validate, [$value]);

				if (!$validateResult['success']) {
					$errors[$field->name][] = $field->validate_error_message
						?? $this->translator->get('validation.in',	['attribute' => $field->label]);
				} elseif ($validateResult['value'] && $field->store) {
					$this->fields[$field->name] = $validateResult['value'];
				}
			}

			if ($field->required && !in_array('required', $rules)) {
				$rules[] = 'required';
			}

			if ($field->pattern) {
				$rules[] = 'regex:/'.$field->pattern.'/';
			}

			if (!empty($rules)) {
				$validatorData[$field->name] = array_filter($rules);
			}
		}

		$validator = $this->factory->make($values, $validatorData, $messages, $attributes);
		$errors = array_merge($errors, $validator->errors()->toArray());

		if (!empty($errors)) {
			throw new FormException(
				'Ошибка при валидации',
				errors: ['fields' => $errors]
			);
		}

		return $this;
	}

	public function getFields(): array
	{
		return $this->fields;
	}

	public function setLocale(string $locale): void
	{
		$this->locale = $locale;
		$this->translator->setLocale($locale);
	}

	private function makeTranslator(): Translator
	{
		$namespace = 'lang';
		$dir = dirname(__DIR__).DIRECTORY_SEPARATOR.$namespace;
		$loader = new FileLoader(new Filesystem(), $dir);
		$loader->addNamespace($namespace, $dir);
		$loader->load($this->locale, 'validation', $namespace);

		return new Translator($loader, $this->locale);
	}
}