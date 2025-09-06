<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UploadController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('upload', []);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'credential' => 'required|file|mimes:json|max:2048',
        ]);

        // todo: verify the json file uploaded with nexus api

        // todo: if success, create another vc with nexus api

        return redirect()->back()->with(['message' => 'success!']);
    }
}
