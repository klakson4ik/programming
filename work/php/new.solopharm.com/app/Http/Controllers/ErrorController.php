<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public function index()
    {

        $meta = [
            'title' => 404,
            'description' => 404,
            'keywords' => 404,
        ];

        return view('error404', [
            'asset' => 'production',
            'meta' => $meta
        ]);
    }
}
