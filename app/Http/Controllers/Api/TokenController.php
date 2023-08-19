<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function csrfToken(Request $request)
    {
        $token = $request->session()->token();
        $token = csrf_token();

        return response()->json(['token' => $token]);
    }
}
