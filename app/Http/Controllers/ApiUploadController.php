<?php

namespace App\Http\Controllers;

use App\Actions\CreateCredentialsInNexusMohesr;
use App\Actions\Verify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:json|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $content = $request->file('file')->get();

        if (!app(Verify::class)($content)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The credential content is not valid.'
            ]);
        }

        if (!app(CreateCredentialsInNexusMohesr::class)($content)) {
            return response()->json([
                'status' => 'error',
                'message' => 'There was a problem with creating the certificate.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Email will be sent out to recipient in 10 mins.'
        ]);
    }
}
