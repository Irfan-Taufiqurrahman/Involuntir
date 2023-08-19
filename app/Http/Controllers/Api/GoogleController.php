<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KodeReferal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    private function generateKodeReferal($user)
    {
        if ($user->role == 'Fundraiser') {
            $kodeReferal = 'FR';
        } elseif ($user->role == 'Volunteer') {
            $kodeReferal = 'VLNTR';
        } else {
            $kodeReferal = 'PDLY';
        }

        return $kodeReferal . $user->id;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'foto' => 'required',
            'key' => 'required',
        ]);

        if (! ($request->key == env('APP_KEY'))) {
            return response()->json(['error' => 'invalid key'], 401);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = JWTAuth::fromUser($user);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'photo' => $request->foto,
                'socialite_id' => $request->uid,
                'email_verified_at' => Carbon::now(),
            ]);

            $token = JWTAuth::fromUser($user);
        }

        if (! $user->id) {
            $user = User::where('email', $user->email)->first();
        }
        if (! KodeReferal::where('id_user', $user->id)->first()) {
            KodeReferal::create([
                'id_user' => $user->id,
                'kode_referal' => $this->generateKodeReferal($user),
            ]);
        }

        return response()->json(compact('token'), 201);
    }
}
