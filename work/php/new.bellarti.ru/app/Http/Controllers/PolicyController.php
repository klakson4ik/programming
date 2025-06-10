<?php

namespace App\Http\Controllers;

use App\Models\Page\PolicyPage;

class PolicyController extends Controller
{
	public function __invoke()
	{
		$data = PolicyPage::get();
		return view('policy', $data);
	}
}
