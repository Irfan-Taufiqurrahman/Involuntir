<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Transaction;
use App\Services\Midtrans\TopupService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    private function generateKode($prefix = 'INVT')
    {
        $time = str_replace('.', '', microtime(true));

        return $prefix . $time;
    }

    public function bank_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            // 'payment_method' => 'required|in:bank_payment',
            'payment_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();
        if (! $user->balance) {
            $user->balance = Balance::create([
                'user_id' => $user->id,
                'amount' => 0,
                'status' => 'active',
            ]);
        }

        $transaction = new Transaction();
        $transaction->invoice_id = $this->generateKode();
        $transaction->user_id = $user->id;
        $transaction->balance_id = $user->balance->id;
        $transaction->amount = $request->amount;
        $transaction->payment_method = 'bank_payment';
        $transaction->payment_name = $request->payment_name;
        $transaction->deadline = Carbon::now()->addDay(1);
        $transaction->status = 'pending';

        $responsePayment = new TopupService($transaction);

        $response = $responsePayment->bankRequest();

        // jika error
        if ($response instanceof Exception) {
            return response()->json([
                'error' => true,
                'message' => $response->getMessage(),
            ], 400);
        }

        // save va number response dari midtrans
        if (isset($response->va_numbers[0]->va_number)) {
            $transaction->va_number = $response->va_numbers[0]->va_number;
        } elseif (isset($response->permata_va_number)) {
            $transaction->va_number = $response->permata_va_number;
        } elseif (isset($response->bill_key) && isset($response->biller_code)) {
            $transaction->va_number = $response->biller_code . ',' . $response->bill_key;
        }

        $transaction->save();
        $transaction->midtrans_response = $response;

        return response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $transaction,
        ], 201);
    }

    public function emoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            // 'payment_method' => 'required|in:emoney',
            'payment_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();
        if (! $user->balance) {
            $user->balance = Balance::create([
                'user_id' => $user->id,
                'amount' => 0,
                'status' => 'active',
            ]);
        }

        $transaction = new Transaction();
        $transaction->invoice_id = $this->generateKode();
        $transaction->user_id = $user->id;
        $transaction->balance_id = $user->balance->id;
        $transaction->amount = $request->amount;
        $transaction->payment_method = 'emoney';
        $transaction->payment_name = 'gopay';
        $transaction->deadline = Carbon::now()->addDay(1);
        $transaction->status = 'pending';

        $responsePayment = new TopupService($transaction);
        $response = $responsePayment->emoneyRequest();

        // jika error
        if ($response instanceof Exception) {
            return response()->json([
                'error' => true,
                'message' => $response->getMessage(),
            ], 400);
        }

        // save link qrcode response dari midtrans
        if (isset($response->actions[0]->url)) {
            $transaction->qr_code = $response->actions[0]->url;
        }

        $transaction->payment_name = $request->payment_name;
        // save
        $transaction->save();
        $transaction->midtrans_response = $response;

        return response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $transaction,
        ], 201);
    }

    public function details(Transaction $transaction)
    {
        return response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $transaction,
        ], 200);
    }
}
