<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function show(Request $request)
    {
        // $voucher = Voucher::find($id);
        $data = DB::table('vouchers')->get();
        return response()->json($data);
    }

    public function bySlug($activity)
    {
        $user = Auth::user();
    
        // Check if the user has a status of "donated"
        if ($user && $user->status === 'donated') {
            // Find vouchers by judul_slug_activity
            $vouchers = Voucher::where('judul_slug_activity', $activity)->get();
    
            if ($vouchers->isEmpty()) {
                return response()->json(['message' => 'No vouchers found for the given judul_slug_activity'], 404);
            }
    
            return response()->json(['status' => true, 'msg' => 'Voucher created successfully!', 'data' => $vouchers], 200);
        } else {
            // If the user does not have a status of "donated", return an error message
            return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
        }
    }
    

    public function create(Request $request, Activity $activity)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name_voucher' => 'required|string',
            'nominal_potongan' => 'required', // Adjust validation as needed
        ]);
    
        // Retrieve the activity based on activity_id
        $activity = Activity::findOrFail($request->activity_id);
    
        // Retrieve the judul_slug value from the activity
        $judul_slug = $activity->judul_slug;
    
        // Create the voucher with judul_slug auto-filled
        $voucher = Voucher::create([
            'activity_id' => $request->activity_id,
            'judul_slug' => $judul_slug, // Auto-fill judul_slug
            'name_voucher' => $request->name_voucher,
            'nominal_potongan' => $request->nominal,
        ]);
    
        // Return response
        return response()->json(['status' => true, 'msg' => 'Voucher created successfully!', 'data' => $voucher], 200);
    }
    

    public function update(Request $request, $id)
    {
        // Find the voucher by ID
        $voucher = Voucher::find($id);

        // Check if voucher exists
        if (!$voucher) {
            return response()->json(['message' => 'Voucher not found'], 404);
        }

        // Validate request data
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'name_voucher' => 'required|string',
            'nominal_potongan' => 'required|integer',
            // 'deadline' => 'nullable',
        ]);

        // Update voucher
        $voucher->update([
            'activity_id' => $request->activity_id,
            'name_voucher' => $request->name_voucher,
            'nominal_potongan' => $request->nominal_potongan,
            // 'deadline' => $request->deadline,
        ]);

        // Return JSON response
        // return response()->json(['voucher' => $voucher], 200);
        return response()->json(['status' => true, 'msg' => 'Voucher created updated!', 'data' => $voucher], 200);        
    }

    public function delete($id)
    {
        // Find the voucher by ID
        $voucher = Voucher::find($id);

        // Check if voucher exists
        if (!$voucher) {
            return response()->json(['message' => 'Voucher not found'], 404);
        }

        // Delete voucher
        $voucher->delete();

        // Return JSON response
        return response()->json(['message' => 'Voucher deleted successfully'], 200);
    }
}