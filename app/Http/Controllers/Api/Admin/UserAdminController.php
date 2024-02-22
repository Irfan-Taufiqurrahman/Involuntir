<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

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
    public function getNewUser()
    {
        try {
            // Mendapatkan tanggal 7 hari yang lalu dari tanggal saat ini
            $sevenDaysAgo = Carbon::now()->subDays(7);

            // Mengambil pengguna yang dibuat dalam 7 hari terakhir
            $newUsers = User::where('created_at', '>=', $sevenDaysAgo)->get();

            // Menyiapkan respons JSON
            $response = [
                'new_users' => $newUsers,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
