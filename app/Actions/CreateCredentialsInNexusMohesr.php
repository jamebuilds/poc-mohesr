<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CreateCredentialsInNexusMohesr
{
    public function __invoke(string $content): bool
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

            $response = Http::withToken(config('services.nexus.token'))
                ->post('https://nexus.uat.accredify.io/api/workflows/9fd3a69a-34ae-46da-a3eb-d1774d776aba/runs', $payload)
                ->json();

//        dd($response);

            if ($response['status'] === "running") {
                return true;
            }

            // todo: handle if api fails
            // todo: handle if json is not in a valid format
        } catch (\Exception $exception) {
            report($exception);
        }

        return false;
    }
}
