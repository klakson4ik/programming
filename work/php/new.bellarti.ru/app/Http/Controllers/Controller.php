<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
	protected function isAjax(Request $request)
	{
		if (!$request->header('content-type')) {
			response()->json([
				'success' => false,
				'message' => 'Not ajax'
			])->send();
			die();
		}
	}

	protected function ajaxFailed(string $msg = 'failed', $data = false)
	{
		response()->json([
			'success' => false,
			'message' => $msg,
			'data' => $data
		])->send();
		die();
	}
}
