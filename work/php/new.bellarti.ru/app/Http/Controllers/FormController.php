<?php

namespace App\Http\Controllers;

use App\Models\Page\FeedbackPage;
use App\Services\GrecaptchaService;
use App\Services\MailService;
use Illuminate\Http\Request;

class FormController extends Controller
{
	public function feedback(Request $request)
	{
		$this->isAjax($request);
		if (!$request->recaptcha_token) {
			$this->ajaxFailed(
				'Captcha не пришла'
			);
		}
		if (!GrecaptchaService::check($request->recaptcha_token)) {
			$this->ajaxFailed(
				'Не удалось пройти проверку Captcha'
			);
		}
		$subject = 'Отзыв от ' . $request->name;
		$body = MailService::getBody(
			[
				'ФИО: ' . $request->name,
				'Email: ' . $request->email,
				'Отзыв: ' . $request->review
			],
			$subject
		);
		$headers = MailService::getHeaders($request->email, $request->name);

		if (mail(env('MAIL_REVIEW'), $subject, $body, $headers)) {
			return response()->json([
				'success' => true,
				'message' => FeedbackPage::getModalData()['success']
			]);
		} else {
			$this->ajaxFailed(
				FeedbackPage::getModalData()['failed'],
				'Не удалось отправить отзыв на email'
			);
		}
	}
}
