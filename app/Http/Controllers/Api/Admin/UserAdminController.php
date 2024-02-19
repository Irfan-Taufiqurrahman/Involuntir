<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAdminController extends Controller
{
    public function index()
{
    $users = User::all();

    return response()->json([
        'status' => true,
        'data' => $users->map(function ($user) {
            return [
                'id'=>$user->id,
                'nama' => $user->name,
                'username'=>$user->username,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'tipe' => $user->tipe,
                'tanggal' => $user->created_at->format('Y-m-d'),
            ];
        }),
    ]);
}
public function changeToOrganisasi($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if($user->tipe==='pribadi'){
                $user->update(['tipe'=>'Organisasi']);
                return response()->json([
                    'status'=>true,
                    'message'=>'Tipe pengguna berhasil diubah menjadi Organisasi',
                ],200);
            }


            if ($user->tipe === 'Individu') {
                $user->update(['tipe' => 'Organisasi']);

                return response()->json([
                    'status' => true,
                    'message' => 'Tipe pengguna berhasil diubah menjadi Organisasi.',
                ],200);
            } 
            if ($user->tipe === 'Organisasi') {
                $user->update(['tipe' => 'Individu']);

                return response()->json([
                    'status' => true,
                    'message' => 'Tipe pengguna berhasil diubah menjadi Individu.',
                ],200);
            }

            else {
                return response()->json([
                    'status' => false,
                    'message' => 'Pengguna sudah memiliki tipe Organisasi atau tipe lainnya.',
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            $user = User::where('email', $request->email)->first();            
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

}
