<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoaDanKabarBaik;
use Illuminate\Http\JsonResponse;

class DoaDanKabarBaikController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(DoaDanKabarBaik::orderBy('created_at')->get());
    }

    public function show(DoaDanKabarBaik $doa): JsonResponse
    {
        return response()->json([
            'data' => [
                'doa' => $doa,
                'user' => $doa->user,
            ],
        ]);
    }
}
