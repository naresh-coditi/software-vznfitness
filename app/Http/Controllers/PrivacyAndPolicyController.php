<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyAndPolicyController extends Controller
{
    public function view()
    {
        return view('frontend.privacy&policy');
    }
}
