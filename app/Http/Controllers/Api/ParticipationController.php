<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityType;
use App\Enums\ParticipationStatus;
use App\Http\Controllers\Controller;
use App\Mail\Participation\ParticipationSubmit;
use App\Models\Activity;
use App\Models\Balance;
use App\Models\Transaction;
use App\Services\Midtrans\ActivityPaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParticipationController extends Controller
{
    public function generateKode($prefix = 'INVA')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function participants(Activity $activity)
    {
        $participants = DB::table('participations')
            ->leftJoin('users', 'participations.user_id', '=', 'users.id')
            ->select('users.*')
            ->where('participations.activity_id', '=', $activity->id)
            ->get();

        return response()->json(['data' => $participants]);
    }

    public function submit(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'nomor_hp' => 'required|numeric|digits_between:10,13',
            'akun_linkedin' => 'sometimes|url|max:255',
            'pesan' => 'sometimes|string',
            'metode' => [
                Rule::requiredIf($activity->jenis_activity->equals(ActivityType::PAID)),
                'in:emoney,bank_payment',
            ],
            'emoney_name' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('metode') == 'emoney';
                }),
                'in:gopay,shopeepay,dana',
            ],
            'bank_name' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('metode') == 'bank_payment';
                }),
                'in:bni,bri,mandiri,permata',
            ],
            'nominal' => [
                Rule::requiredIf(function () use ($request) {
                    return ! empty($request->input('metode'));
                }),
                'numeric',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $validated = $validator->validated();

        if ($activity->jenis_activity->equals(ActivityType::FREE)) {
            return $this->joinActivity($activity, $validated);
        }

        if ($activity->jenis_activity->equals(ActivityType::PAID)) {
            return $this->joinPaidActivity($activity, $validated);
        }

        return response()->json(['message' => 'Activity not found'], 404);
    }

    public function joinPaidActivity(Activity $activity, array $validated)
    {
        $user = Auth::user();

        if ($activity->participants()->where('user_id', auth()->user()->id)->exists()) {
            return response()->json(['message' => 'kamu sudah berpartisipasi pada aktivitas ini'], 409);
        }

        $metode = $validated['metode'];
        $nominal = $validated['nominal'];

        $payment_name = $metode === 'bank_payment' ? $validated['bank_name'] : $validated['emoney_name'];

        // Generate a unique invoice ID
        $invoiceId = $this->generateKode();

        if (! $user->balance) {
            $user->balance = Balance::create([
                'user_id' => $user->id,
                'amount' => 0,
                'status' => 'active',
            ]);
        }

        DB::beginTransaction();

        try {

            $activity->participants()->create([
                'user_id' => $user->id,
                'kode_transaksi' => $invoiceId,
                'nomor_hp' => $validated['nomor_hp'],
                'akun_linkedin' => $validated['akun_linkedin'],
                'pesan' => $validated['pesan'],
                'status' => ParticipationStatus::PENDING,
            ]);

            // Create a new transaction
            $transaction = new Transaction([
                'invoice_id' => $invoiceId,
                'user_id' => $user->id,
                'balance_id' => $user->balance->id,
                'payment_method' => $metode,
                'amount' => $nominal,
                'payment_name' => $payment_name,
                'deadline' => Carbon::now()->addDay(1),
                'status' => 'pending',
            ]);

            // Simpan link QR code atau nomor virtual account berdasarkan metode pembayaran
            if ($metode === 'emoney') {
                $responsePayment = new ActivityPaymentService($transaction, $activity);
                $response = $responsePayment->emoneyRequest();

                // Simpan link QR code untuk pembayaran e-money
                if (isset($response->actions[0]->url)) {
                    $transaction->qr_code = $response->actions[0]->url;
                }

                // Simpan transaksi ke database
                $transaction->save();
            } elseif ($metode === 'bank_payment') {
                $transaction->payment_method = 'bank_payment';

                $responsePayment = new ActivityPaymentService($transaction, $activity);
                $response = $responsePayment->bankRequest();

                if (isset($response->va_numbers[0]->va_number)) {
                    $transaction->va_number = $response->va_numbers[0]->va_number;
                } elseif (isset($response->permata_va_number)) {
                    $transaction->va_number = $response->permata_va_number;
                } elseif (isset($response->bill_key) && isset($response->biller_code)) {
                    $transaction->va_number = $response->biller_code . ',' . $response->bill_key;
                } else {
                    throw new Exception('Error create intend', 500);
                }

                $transaction->save();
            }

            $transaction->save();

            Mail::to($user->email)->send(new ParticipationSubmit($user->name, $nominal, $metode, $activity->judul_activity));
            DB::commit();

            $transaction->midtrans_response = $response;

            return response()->json([
                'error' => false,
                'message' => 'success',
                'data' => $transaction,

            ], 201);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['status' => 202, 'message' => 'failed: ' . $e]);
        }
    }

    public function joinActivity(Activity $activity, array $validated)
    {
        $user_id = Auth::user()->id;

        if ($activity->participants()->where('user_id', auth()->user()->id)->exists()) {
            return response()->json(['message' => 'kamu sudah berpartisipasi pada aktivitas ini'], 409);
        }

        $participation = $activity->participants()->create([
            'user_id' => $user_id,
            'nomor_hp' => $validated['nomor_hp'],
            'akun_linkedin' => $validated['akun_linkedin'],
            'pesan' => $validated['pesan'],
            'status' => ParticipationStatus::APPROVED,
        ]);

        return response()->json(['data' => $participation]);
    }
}
