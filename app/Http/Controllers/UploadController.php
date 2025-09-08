<?php

namespace App\Http\Controllers;

use App\Actions\CreateCredentialsInNexusMohesr;
use App\Actions\Verify;
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

        $content = $request->file('credential')->get();

        if (!app(Verify::class)($content)) {
            return back()->withErrors([
                'credential' => 'The credential content is not valid.'
            ]);
        }

        if (!app(CreateCredentialsInNexusMohesr::class)($content)) {
            return back()->withErrors([
                'credential' => 'There was a problem with creating the certificate.'
            ]);
        }

        return redirect()->back();
    }
}
