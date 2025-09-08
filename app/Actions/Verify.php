<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class Verify
{
    public function __invoke(string $content): bool
    {
        try {
            // call verify endpoint to check
            $response = Http::attach('file', $content, 'file.json')
                ->withToken(config('services.nexus.token'))
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
//                && $response['not_revoked'] === false // dont think need to check for revoke?
            ) {
                return true;
            }
        } catch (\Exception $exception) {
            report($exception);
        }

        return false;
    }
}
