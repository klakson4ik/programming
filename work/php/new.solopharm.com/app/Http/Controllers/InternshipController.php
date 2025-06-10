<?php

namespace App\Http\Controllers;

use App\Models\Pages\InternshipPage;
use App\Services\MailService;
use App\Services\MetaService;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $page = InternshipPage::getPage();

        $data = [
            'asset' => 'internship',
            'page' => $page,
            'meta' => MetaService::getData($page),
        ];

        return view('internship', $data);
    }

    public function store(Request $request)
    {
        $subject = __('pages.mail.internship.subject');
        $file = MailService::getFile($_FILES['file']);
        $message = MailService::getBody(
            [
                __('form.fio') . ': ' . $request->name,
                __('form.university') . ': ' . $request->university,
                __('form.course') . ': ' . $request->course,
                __('form.faculty') . ': ' . $request->faculty,
                __('form.date-start') . ': ' . $request->date_start,
                __('form.date-end') . ': ' . $request->date_end,
                __('form.phone') . ': ' . $request->phone,
                __('form.email') . ': ' . $request->email,
                __('form.direction') . ': ' . $request->direction,
                __('form.letter') . ': ' . $request->letter,

            ],
            $subject
        );
        $headers = MailService::getHeaders($request->email, $request->name, true);
        $body = MailService::getMixedBody($message, $file);

        mail(config('constant.mail.hr'), $subject, $body, $headers);

        return back()->with('status', 'send');
    }
}
