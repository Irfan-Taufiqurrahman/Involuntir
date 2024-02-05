<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
{
    $users = User::paginate();

    return response()->json([
        'status' => true,
        'data' => $users->map(function ($user) {
            return [
                'nama' => $user->name, // Gantilah 'nama' sesuai dengan atribut yang sesuai di model User
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'tipe' => $user->tipe,
                'tanggal' => $user->created_at->format('Y-m-d'), // Sesuaikan format tanggal sesuai kebutuhan
            ];
        }),
    ]);
}
public function changeToOrganisasi($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Pastikan bahwa pengguna memiliki tipe 'Individu' sebelum diubah
            if ($user->tipe === 'Individu') {
                $user->update(['tipe' => 'Organisasi']);

                return response()->json([
                    'status' => true,
                    'message' => 'Tipe pengguna berhasil diubah menjadi Organisasi.',
                ]);
            } else {
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


}
