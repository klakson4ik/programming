<?php

namespace App\Http\Controllers;

use App\Models\Page\Error404Page;


class Error404Controller extends Controller
{

	protected $data;

	public function __construct()
	{
		$this->data = Error404Page::get();
	}

	public function index()
	{
		$this->data['haveBreadcrumbs'] = false;
		return response()->view(
			'errors.404',
			$this->data,
			404
		);
	}
}
