<?php

namespace App\Services\Forms\Captcha;

use App\Services\Forms\Exceptions\FormException;
use App\Services\Forms\Interfaces\CaptchaInterface;
use Bitrix\Main\Web\HttpClient;

final class GoogleCaptcha implements CaptchaInterface
{
	private string $url = 'https://www.google.com/recaptcha/api/siteverify';
	private ?string $token;
	private float $minScore = 0.3;
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
			throw new FormException('Ошибка при проверке на робота', errors: [
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

		if (!$result?->success || !($result?->score >= $this->minScore)) {
			throw new FormException('Ошибка при проверке на робота', errors: [
				'token' => 'Не пройденна провека на робота'
			]);
		}
	}

	private function request()
	{
		$result = $this->client->post($this->url, [
			'secret' => $this->secretKey(),
			'response' => $this->token,
		]);

		return json_decode($result);
	}

	private function secretKey(): string
	{
		return 'token';
	}
}