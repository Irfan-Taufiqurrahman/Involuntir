<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\MailVerification;
use App\Models\KodeReferal;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Namshi\JOSE\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;

class AuthController extends Controller
{
    private function generateKodeReferal() {
        $user = DB::table('users')->select('id', 'role')
                                  ->where('id', '=', Auth::user()->id)
                                  ->first();

        if ($user->role == 'Fundraiser')
            $kodeReferal = 'FR';
        else if ($user->role == 'Volunteer')
            $kodeReferal = 'VLNTR';
        else
            $kodeReferal = 'PDLY';
        
        return $kodeReferal.$user->id;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            $user = User::where('email', $request->email)->first();
            if(!KodeReferal::where('id_user', $user->id)->first()) {
                KodeReferal::create([
                    'id_user' => $user->id,
                    'kode_referal' => $this->generateKodeReferal()
                ]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function registerverif(Request $request)
    {
        $validator = Validator::make(request()->only('name', 'email', 'password'), [
            'name' => 'required|min:2|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password)
        ]);

        // KodeReferal::create([
        //     'id_user' => $user->id,
        //     'kode_referal' => $this->generateKodeReferal()
        // ]);

        $token = JWTAuth::fromUser($user);

        $link = env('APP_URL') . "/email/verification?email=$request->email&token=$token";

        Mail::to($request->email)->send(new MailVerification($user, $link));

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * @deprecated
     */
    public function register(Request $request)
    {
        $validator = Validator::make(request()->only('name', 'email', 'password'), [
            'name' => 'required|min:2|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = new User([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password)
        ]);
        $token = JWTAuth::fromUser($user);

        $user->sendEmailVerificationNotification();
        return response()->json(compact('user', 'token'), 201);
    }

    public function logout(Request $request)
    {

        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate($token);

            return response()->json([
                'error'   => false,
                'message' => trans('auth.logged_out')
            ]);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.expired')
            ], 401);
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.invalid')
            ], 401);
        } catch (JWTException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.missing')
            ], 500);
        }
    }

    public function cekVerifEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!$user->hasVerifiedEmail()) {
                return response()->json(["error" => true, "message" => "email belum diverifikasi"], 401);
            }

            return response()->json(["error" => false, "message" => "email sudah diverifikasi"], 200);
        }

        return response()->json(["error" => true, "message" => "email tidak ditemukan"], 404);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $user->balance;
            // $user->kode_referal;
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function sendVerifEmail(Request $request)
    {
        $token = $request->bearerToken();

        $user = auth('api')->user();

        if (!$user) {
            return response()->json(["error" => true, "message" => "token invalid"]);
        }

        $link = env('APP_URL') . "/email/verification?email=$user->email&token=$token";

        Mail::to($user->email)->send(new MailVerification($user, $link));

        return response()->json(["error" => false, "message" => "email verifikasi sudah terkirim"], 201);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleAuthCallbackGoogle(): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var User $user */
        $user = User::query()
            ->firstOrCreate(
                [
                    'email' => $socialiteUser->getEmail(),
                ],
                [
                    'email_verified_at' => Carbon::now(),
                    'name' => $socialiteUser->getName(),
                    'socialite_id' => $socialiteUser->getId(),
                    'photo' => $socialiteUser->getAvatar(),
                    'socialite_name' => $socialiteUser->getName(),
                ]
            );

        if(!$user->id)
            $user = User::where('email', $socialiteUser->getEmail())->first();
        if(!KodeReferal::where('id_user', $user->id)->first()) {
            KodeReferal::create([
                'id_user' => $user->id,
                'kode_referal' => $this->generateKodeReferal()
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
        ]);
    }
}
