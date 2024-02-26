<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\ActivityType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Activity;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class DashboardAdminController extends Controller{
    public function show()
    {
        // Menghitung total aktivitas yang sedang berlangsung (ongoing)
        $ongoingActivitiesCount = Activity::where('batas_waktu', '>', Carbon::now())->count();

        // Menghitung total aktivitas yang telah selesai
        $completedActivitiesCount = Activity::where('batas_waktu', '<', Carbon::now())->count();
        
        // Menghitung total aktivitas (yang selesai dan yang sedang berlangsung)
        $totalActivitiesCount = Activity::count();
        // Menghitung total donasi dalam setahun per bulan
        $monthlyDonations = Donation::select('id','donasi','created_at','kode_donasi','status_donasi','nama','donasi','nomor_telp','tanggal_donasi')->get();
        // $activity = Activity::all();
        $activities = Activity::all();
          
        // $activities = $query->get();
    
        $formattedData = $activities->map(function ($activity) {
                $price = $activity->prices()->where('activity_id', $activity->id)->first();
                
                $user = $activity->user;
                
                $jumlahVolunteer = $activity->donations()->where('status_donasi', 'Approved')->count();
                
                $totalIncome = $activity->donations()->where('status_donasi', 'Approved')->sum('donasi');
                
                $priceValue = $price ? $price->price : null;
            
                $madeBy = $user ? $user->name : null;
                $batasWaktu = strtotime($activity->batas_waktu);
                $hariIni = time();
                $selisihDetik = $batasWaktu - $hariIni;
                $selisihHari = floor($selisihDetik / (60 * 60 * 24)); // Mengonversi selisih dalam detik menjadi hari
                return [
                    'id' => $activity->id,
                    'name' => $activity->judul_activity,
                    'price' => $priceValue,
                    'foto_activity'=>$activity->foto_activity,
                    'total_income' => $totalIncome,
                    'jumlah_volunteer' => $jumlahVolunteer,
                    'batas_waktu' => $selisihHari,                    
                    'created_at'=> $activity->created_at,
                ];
            });
        $sevenDaysAgo = Carbon::now()->subDays(7);

            // Mengambil pengguna yang dibuat dalam 7 hari terakhir
            // $newUsers = User::where('created_at', '>=', $sevenDaysAgo)->get();

        $newUsers = User::select('id', 'name', 'username', 'email', 'no_telp', 'tipe', 'created_at')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->get();
        $categories = Category::withCount('activities')->get(['id', 'nama_kategori', 'activities_count']);
        $data_categories = $categories->map(function ($category) {
                return [
                    'label' => $category->name,
                    'jumlah' => $category->activities_count,
                ];
            });
        $totalApprovedVolunteer = Donation::where('status_donasi', 'Approved')->count();
        $totalApprovedDonation = Donation::where('status_donasi', 'Approved')->sum('donasi');
        $lastUserId = User::latest()->value('id');
            return response()->json([
            'status' => [
                'ongoing'=>$ongoingActivitiesCount,
                'finished'=>$completedActivitiesCount,
                'total'=>$totalActivitiesCount,
            ],
            'total_donation' => $monthlyDonations,
            'activity'=>$formattedData,
            'new_user'=>json_decode($newUsers),
            'total_categories'=>$data_categories,
            'total_all_donation'=>$totalApprovedDonation,
            'total_all_volunteer'=>$totalApprovedVolunteer,
            'total_user'=>$lastUserId
        ]);
    }
}