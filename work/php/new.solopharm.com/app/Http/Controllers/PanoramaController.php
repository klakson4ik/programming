<?php

namespace App\Http\Controllers;

class PanoramaController extends Controller
{
    public function index()
    {
        return view('partials.3d-tour');
    }
}
