<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermAndConditionController extends Controller
{
    public function view()
    {
        return view('frontend.terms&conditions');
    }
}
