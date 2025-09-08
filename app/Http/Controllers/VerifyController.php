<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyController extends Controller
{
    public function create(Request $request): View
    {
        return view('verify');
    }
}
