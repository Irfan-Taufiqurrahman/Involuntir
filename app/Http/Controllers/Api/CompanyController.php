<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request) {
        if($request->has('latitude') && $request->has('longitude')) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            // menggunakan rumus untuk menghitung jarak anatar user dan company
            $companies = Company::selectRaw('*, ( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?)
            ) + sin( radians(?) ) *
            sin( radians( latitude ) ) )
            ) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '!=', "")
            ->orderBy('distance')
            ->get();
        } else {
            $companies = Company::all();
        }

        return response()->json([
            'status' => 'success',
            'data' => $companies
        ]);
    }
}
