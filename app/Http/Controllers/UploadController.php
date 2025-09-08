<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Http;

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
        $token = config('services.nexus.token');

        if (!$this->verify($content, $token)) {
            return back()->withErrors([
                'credential' => 'The credential content is not valid.'
            ]);
        }

        if (!$this->createCredentialsInNexusMohesr($content, $token)) {
            return back()->withErrors([
                'credential' => 'There was a problem with creating the certificate.'
            ]);
        }

        return redirect()->back();
    }

    private function createCredentialsInNexusMohesr(string $content, string $token): bool
    {
        try {
            // transform the data to something that can be uploaded to the api
            $data = json_decode($content, true)['data'];

            // Extract recipient name and email by removing UUID prefixes
            $recipientName = explode(':', $data['recipient']['name'])[2] ?? $data['recipient']['name'];
            $recipientEmail = explode(':', $data['recipient']['email'])[2] ?? $data['recipient']['email'];

            // Transform to API format
            $payload = [
                'documents' => [
                    [
                        'id' => Str::uuid()->toString(),
                        'recipient' => [
                            'name' => $recipientName,
                            'email' => $recipientEmail,
                        ]
                    ]
                ]
            ];

            $response = Http::withToken($token)
                ->post('https://nexus.uat.accredify.io/api/workflows/9fd3a69a-34ae-46da-a3eb-d1774d776aba/runs', $payload)
                ->json();

//        dd($response);

            if ($response['status'] === "running") {
                return true;
            }

            // todo: handle if api fails
            // todo: handle if json is not in a valid format
        } catch (\Exception $exception) {

        }

        return false;
    }

    private function verify(string $content, string $token): bool
    {
        try {
            // call verify endpoint to check
            $response = Http::attach('file', $content, 'file.json')
                ->withToken($token)
                ->post('https://nexus.uat.accredify.io/verification/v1/verify')
                ->json();

//        dd($response);

            // todo: get the verification endpoint from the registry based on the vc's domain
            // todo: check against is a valid school from a registry

            // todo: handle http error
            // todo: handle if response tampered
            // todo: handle if issuer not valid

            /*
             * api response structure
             * array:5 [
                  "not_tampered" => true
                  "valid_issuer" => true
                  "recognized_institute" => true
                  "not_revoked" => false
                  "trace_id" => "f4ff5b2d-4e16-4957-a13b-bbed4f02b6b4"
                ]
             */

            if ($response['not_tampered'] === true
                && $response['valid_issuer'] === true
                && $response['recognized_institute'] === true
//                && $response['not_revoked'] === false
            ) {
                return true;
            }
        } catch (\Exception $exception) {

        }

        return false;
    }
}
