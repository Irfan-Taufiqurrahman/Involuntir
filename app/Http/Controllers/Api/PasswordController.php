<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\resetMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

        $link = env('FRONTEND_URL')."/password/reset?email=$request->email&token=$tokenData";

        Mail::to($request->input('email'))->send(new resetMail($user, $link));

        return response()->json([
            'status'=>201,
            'msg'=>'email sended'
        ]);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'new_pass'  => 'required|min:8'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tokenData = DB::table('password_resets')
            ->where('email', $request->input('email'))
            ->where('token', $request->input('token'))
            ->first();

        return response()->json($request->all());

        if (!$tokenData) {
            $exception =  '';
            try{
                DB::table('password_resets')
                    ->where('email', $request->input('email'))
                    ->orWhere('token', $request->input('token'))
                    ->delete();
            }catch(Exception $e){
                $exception = $e;
            }
            return response()->json([
                "status" => 202,
                "msg" => 'Gagal mengubah password',
                "exc" => $exception
            ]);
        }

        $newPass = $request->input('new_pass');

        DB::table('users')
            ->where('email', $request->input('email'))
            ->update([
                'password'=>bcrypt($newPass)
            ]);

        DB::table('password_resets')
            ->where('email', $request->input('email'))
            ->where('token', $request->input('token'))
            ->delete();

        return response()->json([
            'status'=>201,
            'msg'=>'sukses mengganti password'
        ]);
    }

    public function testbcrypt(Request $request){
        $pass = $request->input('password');

        return response()->json(bcrypt($pass));
    }
}
