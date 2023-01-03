<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountVerification;
use App\Models\KodeReferal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountVerificationController extends Controller
{
    // create index, create function
    public function index()
    {
        $accountVerifications = AccountVerification::where('status', 'pending')->orderBy('created_at')->get();
        return response()->json(['message' => 'success', 'data' => $accountVerifications], 200);
    }

    public function pribadi(Request $request)
    {
        $user = Auth::user();

        if(strtolower($user->tipe) === 'organisasi') {
            return response()->json(['message' => 'Anda bukan bertipe pribadi'], 400);
        }

        $validator = Validator::make($request->all(), [
            'foto_ktp' => 'required|image:png,jpg,jpeg',
            'foto_diri_ktp' => 'required|image:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'data' => $validator->errors()], 400);
        }

        $accountVerification = AccountVerification::where('user_id', $user->id)->first();

        if (!$accountVerification) {
            $imageName = $user->email;

            $fotoKtp = "KTP_" . $imageName . "." . $request->file('foto_ktp')->extension();
            $fotoDiriKtp = "DIRI_KTP_" . $imageName . "." . $request->file('foto_diri_ktp')->extension();
            $request->file('foto_ktp')->move(public_path('images/images_verification'), $fotoKtp);
            $request->file('foto_diri_ktp')->move(public_path('images/images_verification'), $fotoDiriKtp);
            $accountVerification = AccountVerification::create([
                'user_id' => $user->id,
                'foto_ktp' => "/images/images_verification/$fotoKtp",
                'foto_diri_ktp' => "/images/images_verification/$fotoDiriKtp",
                'status' => 'pending',
            ]);
        }

        return response()->json($accountVerification, 201);
    }

    public function organisasi(Request $request){
        $user = Auth::user();

        if(strtolower($user->tipe) !== 'organisasi') {
            return response()->json(['message' => 'Anda bukanlah organisasi'], 400);
        }

        $validator = Validator::make($request->all(), [
            'telp_pj' => 'required|string',
            'foto_ktp' => 'required|image:png,jpg,jpeg',
            'foto_diri_ktp' => 'required|image:png,jpg,jpeg',
            'foto_npwp' => 'required|image:png,jpg,jpeg',
            'foto_diri_npwp' => 'required|image:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'data' => $validator->errors()], 400);
        }

        $accountVerification = AccountVerification::where('user_id', $user->id)->first();

        if (!$accountVerification) {
            $imageName = $user->email;

            $fotoKtp = "KTP_" . $imageName . "." . $request->file('foto_ktp')->extension();
            $fotoDiriKtp = "DIRI_KTP_" . $imageName . "." . $request->file('foto_diri_ktp')->extension();
            $fotoNpwp = "NPWP_" . $imageName . "." . $request->file('foto_npwp')->extension();
            $fotoDiriNpwp = "DIRI_NPWP_" . $imageName . "." . $request->file('foto_diri_npwp')->extension();

            $request->file('foto_ktp')->move(public_path('images/images_verification'), $fotoKtp);
            $request->file('foto_diri_ktp')->move(public_path('images/images_verification'), $fotoDiriKtp);
            $request->file('foto_npwp')->move(public_path('images/images_verification'), $fotoNpwp);
            $request->file('foto_diri_npwp')->move(public_path('images/images_verification'), $fotoDiriNpwp);

            $accountVerification = AccountVerification::create([
                'user_id' => $user->id,
                'foto_ktp' => "/images/images_verification/$fotoKtp",
                'foto_diri_ktp' => "/images/images_verification/$fotoDiriKtp",
                'foto_npwp' => "/images/images_verification/$fotoNpwp",
                'foto_diri_npwp' => "/images/images_verification/$fotoDiriNpwp",
                'status' => 'pending',
            ]);
        }

        return response()->json($accountVerification, 201);
    }

    public function verified(AccountVerification $accountVerification) {
        $accountVerification->status = 'verified';
        $accountVerification->save();

        $user = User::find($accountVerification->user_id);
        $user->status_akun = 'Verified';
        
        if(!$user->kode_referal){
            KodeReferal::create([
                'id_user' => $user->id,
                'kode_referal' => $this->generateKodeReferal($user->role)
            ]);
        }

        $user->save();
        return response()->json(['message' => 'success', 'data' => $user], 200);
    }

    private function generateKodeReferal($role) {
        $last_kode_referal = KodeReferal::latest()->first();
        // reverse string
        $reverse_kode_ref = strrev($last_kode_referal->kode_referal);

        $spllitted_kode_ref = preg_split('#(?<=\d)(?=[a-z])#i', $reverse_kode_ref);
        $last_number = strrev($spllitted_kode_ref[0]);


        if($last_number[0] == 0) {
            $next_kode_ref = KodeReferal::getRefUser()[$role] . '0' . (intval($last_number[1]) + 1);
        } else {
            $next_kode_ref = KodeReferal::getRefUser()[$role] . (intval($last_number) + 1);
        }

        return $next_kode_ref;
    }
}
