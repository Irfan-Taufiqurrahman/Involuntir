<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class EmailVerifController extends Controller
{
    public function verifEmail(Request $request)
    {
        if (! $request->email) {
            return abort(404, 'Not found');
        }

        $user = User::where('email', $request->email)->first();

        $currentDate = Carbon::now()->toDateTimeString();

        $user->email_verified_at = $currentDate;

        $user->save();

        return Redirect::intended(env('FRONTEND_URL') . '/register/VerifikasiBerhasil');
    }
}
