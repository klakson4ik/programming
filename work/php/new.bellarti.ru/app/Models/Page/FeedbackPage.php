<?php

namespace App\Models\Page;

class FeedbackPage extends StaticModel
{
	protected const PAGE = 'feedback';

	public static function get()
	{
		$data =  [
			'title' => 'Оставить отзыв',
			'img' => self::getImage('feedback-bg.png'),
			'formData' => self::getFormData(),

			'seo_title' => 'Оставить отзыв',
			'seo_description' => 'Оставить отзыв',
			'seo_keywords' => 'Bellarti',
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getFormData()
	{
		return [
			'name' => 'feedback',
			'action' => '/form/feedback',
			'fields' => [
				[
					'field' => 'grecaptcha',
					'type' => 'hidden',
					'name' => 'grecaptcha-token',
					'scriptSrc' => 'https://www.google.com/recaptcha/api.js?render=',
					'publicKey' => env('GRECAPTCHA_PUBLIC_KEY')
				],
				[
					'field' => 'input',
					'type' => 'text',
					'name' => 'name',
					'placeholder' => 'Ваше ФИО',
					'required' => true,
				],
				[
					'field' => 'input',
					'type' => 'email',
					'name' => 'email',
					'placeholder' => 'Ваш email',
					'required' => true,
				],
				[
					'field' => 'textarea',
					'type' => 'text',
					'name' => 'review',
					'placeholder' => 'Ваш отзыв',
					'required' => true,
					'rows' => 10
				],
				[
					'field' => 'checkbox',
					'name' => 'agreement',
					'required' => true,
					'label' => 'Я согласен/согласна на&nbsp;<a href="/policy" class="c-purple">обработку персональных данных</a>'
				],
				[
					'field' => 'submit',
					'value' => 'Отправить'
				],
			]
		];
	}

	public static function getModalData()
	{
		return [
			'success' => 'Спасибо, нам очень важно получить вашу обратную связь! Ваш отзыв принят, он пройдет проверку модератором и будет опубликован',
			'failed' => 'Что-то пошло не так, попробуйте позже'
		];
	}
}
