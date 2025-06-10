<?php

namespace App\Http\Controllers;

use App\Models\Page\Error500Page;


class Error500Controller extends Controller
{

	protected $data;

	public function __construct()
	{
		$this->data = Error500Page::get();
	}

	public function index()
	{
		$this->data['haveBreadcrumbs'] = false;
		return response()->view(
			'errors.500',
			$this->data,
			500
		);
	}
}
