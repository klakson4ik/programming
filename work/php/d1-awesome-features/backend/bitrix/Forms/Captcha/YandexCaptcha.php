<?php

namespace App\Services\Forms\Captcha;

use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\CaptchaInterface;
use Bitrix\Main\Web\HttpClient;

class YandexCaptcha implements CaptchaInterface
{
	public const STATUS_FAILED = 'failed';
	public const STATUS_SUCCESS = 'ok';

	private string $url = 'https://smartcaptcha.yandexcloud.net/validate';
	private ?string $token;
	private HttpClient $client;

	public function __construct()
	{
		$this->client = new HttpClient();
	}

	/**
	 * @throws FormException
	 */
	public function verify(?string $token): void
	{
		$this->token = $token;

		$this->verifyByExist();
		$this->verifyByRequest();
	}

	/**
	 * @throws FormException
	 */
	private function verifyByExist(): void
	{
		if (!$this->token) {
			throw new FormException('Ошибка при проверке капчи', errors: [
				'token' => 'Не передан токен'
			]);
		}
	}

	/**
	 * @throws FormException
	 */
	private function verifyByRequest(): void
	{
		$result = $this->request();

		if (!$result || $result->status === self::STATUS_FAILED || $result->status !== self::STATUS_SUCCESS) {
			throw new FormException('Ошибка при проверке капчи', errors: [
				'token' => 'Не пройденна провека на робота'
			]);
		}
	}

	private function request()
	{
		$query = http_build_query([
			"secret" => $this->secretKey(),
			"token" => $this->token,
			"ip" => $_SERVER['REMOTE_ADDR']
		]);

		$result = $this->client->get($this->url.'?'.$query);

		return json_decode($result);
	}

	private function secretKey(): string
	{
		//TODO: return token
		return 'token';
	}
}