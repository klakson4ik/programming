<?php

namespace App\Http\Controllers;

use App\Models\Page\FeedbackPage;

class FeedbackController extends Controller
{

	public function __invoke()
	{
		$data = FeedbackPage::get();

		return view('feedback', $data);
	}
}
