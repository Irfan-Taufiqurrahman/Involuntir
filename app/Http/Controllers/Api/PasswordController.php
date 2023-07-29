<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\resetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function resetEmail(Request $request)
    {
        $user = DB::table('users')->where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                "status" => 202,
                "msg" => 'User tidak ditemukan'
            ]);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now('Asia/Jakarta')
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first()->token;

        $link = env('FRONTEND_URL') . "/password/reset?email=$request->email&token=$tokenData";

        Mail::to($request->input('email'))->send(new resetMail($user, $link));

        return response()->json([
            'status' => 201,
            'msg' => 'email sended'
        ], 201);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $status = Password::reset(
            $validator->safe()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );


        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 201,
                'message' => 'sukses mengganti password'
            ], 201);
        }

        if ($status == Password::INVALID_TOKEN) {
            return response()->json([
                'status' => 400,
                'error' => trans($status),
            ], 400);
        }
    }

    public function requestOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->input('email');
        $otp = rand(100000, 999999);
        $expiryTime = now()->addMinutes(10);

        $user = User::where('email', $email)->first();

        // Simpan OTP dan waktu kedaluwarsa ke database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['email' => $email, 'otp' => $otp, 'expires_at' => $expiryTime]
        );

        // Kirim OTP ke email pengguna
        Mail::send('emails.reset-password', ['otp' => $otp, 'user' => $user->name], function ($message) use ($email) {
            $message->to($email)->subject('Reset Password OTP');
        });

        return response()->json([
            'otp' => $otp,
            'message' => 'OTP sent successfully'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->input('email');
        $otp = $request->input('otp');

        // Cek apakah OTP cocok dengan yang ada di database dan belum kedaluwarsa
        $resetData = DB::table('password_resets')->where('email', $email)->first();
        if ($resetData && $resetData->otp == $otp && now() <= $resetData->expires_at) {
            // Jika OTP valid, berikan token atau lanjutkan proses reset password di sini
            $token = Password::createToken(User::where('email', $email)->first());

            return response()->json(['message' => 'OTP verified successfully']);
        } else {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }
    }

    public function testbcrypt(Request $request)
    {
        $pass = $request->input('password');

        return response()->json(bcrypt($pass));
    }
}
