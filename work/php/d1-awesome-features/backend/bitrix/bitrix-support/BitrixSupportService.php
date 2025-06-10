<?php

namespace App\Services\BitrixSupport;

use App\Services\BitrixSupport\Ticket\Ticket;
use Bitrix\Main\Loader;

final class BitrixSupportService
{
	public readonly Dictionary $dictionary;
	public readonly Ticket $ticket;

	private static ?self $_instance = null;

	private function __construct()
	{
		Loader::includeModule('support');

		$this->dictionary = new Dictionary();
		$this->ticket = new Ticket();
	}

	public static function instance(): self
	{
		return self::$_instance ??= new self;
	}
}