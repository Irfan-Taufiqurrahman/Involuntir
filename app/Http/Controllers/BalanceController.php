<?php

namespace App\Http\Controllers;

use App\Mail\DonasiBerhasil;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    public function generateKode($prefix = 'INVD')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required|numeric|min:100',
            'metode' => 'required|in:balance',
            'campaign_id' => 'required|exists:campaigns,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = auth()->user();

        if ($user->balance->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Saldo anda tidak aktif',
            ], 400);
        }

        if ($user->balance->amount < $request->nominal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Saldo anda tidak mencukupi',
            ], 400);
        }

        $user->balance->amount -= $request->nominal;
        $user->balance->save();

        $id_donasi = Donation::insertGetId([
            'nama' => $user->name,
            'donasi' => $request->nominal,
            'kode_donasi' => $this->generateKode(),
            'metode_pembayaran' => $request->metode,
            'email' => $user->email,
            'nomor_telp' => $user->phone ? $user->phone : null,
            'komentar' => $request->pesan_baik,
            'user_id' => $request->user_id ? $request->user_id : $user->id,
            'campaign_id' => $request->campaign_id,
            'tanggal_donasi' => Carbon::now(new \DateTimeZone('Asia/Jakarta')),
            'deadline' => date('created_at', strtotime('+1 day')),
            'status_donasi' => 'Approved',
        ]);

        $donation = Donation::with('campaign')->where('id', $id_donasi)->first();

        $donation->metode_pembayaran = 'Dompet Peduly';

        // Mail::to($data->email)->send(new DonasiBerhasil($data));

        DB::table('akun_anonim')->insert([
            'id_donasi' => $donation->id,
            'nama' => $user->name,
            'email' => $user->email,
            'no_hp' => $user->nomor_hp ? $user->nomor_hp : null,
            'kode_referal' => $request->kode_referensi,
        ]);

        return response()->json(['data' => ['donasi' => $donation], 'status' => 201, 'msg' => 'success']);
    }
}
