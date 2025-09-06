<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UploadController extends Controller
{
    public function __invoke(Request $request): Response
    {
        // todo: verify the json file uploaded with nexus api

        // todo: if success, create another vc with nexus api

        return Inertia::render('upload', []);
    }
}
