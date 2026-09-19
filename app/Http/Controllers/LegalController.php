<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function terms()
    {
        return view('legal.terms');
    }
}
