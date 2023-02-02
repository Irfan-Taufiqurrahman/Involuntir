<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Mail\SubmitDonation;
use App\Models\Activity;
use App\Models\Participation;
// use App\Services\Midtrans\BankPaymentService;
// use App\Services\Midtrans\EMoneyPayment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ParticipationController extends Controller
{
    public function participants(Activity $activity)
    {
        $participants = DB::table('participations')
                        ->leftJoin('users', 'participations.user_id', '=', 'users.id')
                        ->select('users.*')
                        ->where('participations.activity_id', '=', $activity->id)
                        ->get();
        return response()->json(['data' => $participants]);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activity_id' => 'required|numeric',
            'nomor_hp' => 'required|numeric|digits_between:10,255',
            'akun_linkedin' => 'nullable|string|max:255',
            'pesan' => 'nullable|string',
        ]);
        
        if($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $activity_id = $request->input('activity_id');
        $user_id = Auth::user()->id;
        $nomor_hp = $request->input('nomor_hp');
        $akun_linkedin = $request->input('akun_linkedin');
        $pesan = $request->input('pesan');

        $hasParticipate = Participation::where('user_id', $user_id);

        if($hasParticipate) {
            return response()->json(['message' => 'anda sudah berpartisipasi pada aktivitas ini'], 409);
        }

        $activity = Activity::where('id', $activity_id)->first();

        if(!$activity) {
            return response()->json(['message' => 'campaign tidak ditemukan'], 400);
        }

        $participation = Participation::create([
            'activity_id' => $activity_id,
            'user_id' => $user_id,
            'nomor_hp' => $nomor_hp,
            'akun_linkedin' => $akun_linkedin,
            'pesan' => $pesan
        ]);

        return response()->json(['data' => $participation]);
    }
}