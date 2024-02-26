<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\ActivityType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Participation;
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

class ActivityAdminController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Activity(); // Sesuaikan dengan model Anda
    }
    private $data = null;
    private function categoryFiltering($id)
    {
        $this->data = Activity::where('category_id', $id);
    }

    private function orderByFiltering($order)
    {
        if ($order === 'mendesak') {
            $this->data = $this->data ? $this->data->orderBy('activities.batas_waktu', 'ASC') : Activity::orderBy('activities.batas_waktu', 'ASC');
        } elseif ($order === 'populer') {
            $this->data = $this->data ? $this->data->orderBy(DB::raw('total_volunteer'), 'DESC') : Activity::orderBy(DB::raw('total_volunteer'), 'DESC');
        } elseif ($order === 'terbaru') {
            $this->data = $this->data ? $this->data->orderBy('activities.created_at', 'DESC') : Activity::orderBy('activities.created_at', 'DESC');
        } else {
            throw new HttpClientException('invalid order key', 400);
        }
    }

    private function byFiltering($filter)
    {
        $roles = [
            'peduly' => 'users.tipe = "Fundraiser" OR users.tipe = "Volunteer"',
            'organisasi' => 'users.tipe = "Organisasi"',
            'pribadi' => 'users.tipe = "pribadi" OR users.tipe = "Individu"',
        ];

        if (! array_key_exists($filter, $roles)) {
            throw new HttpClientException('invalid filter key', 400);
        }

        $this->data = $this->data ? $this->data->join('users', 'users.id', '=', 'activities.user_id')
            ->whereRaw($roles[$filter])
            : Activity::join('users', 'users.id', '=', 'activities.user_id')->whereRaw($roles[$filter]);
    }

    private function getAllActivitiesWithoutFiltering()
    {
        return Activity::orderBy('created_at', 'DESC');
    }

    private function getAllActivitiesWithoutFilteringWithLimit($limit)
    {
        $this->data = $this->data ? $this->data->limit($limit) : Activity::limit($limit);
    }
    public function index()
    {
        try {
            $query = $this->model->newQuery(); // Menginisialisasi kueri Eloquent
            
            if (request()->kategori) {
                $this->categoryFiltering(request()->kategori, $query);
            }
    
            if (request()->urutan) {
                $this->orderByFiltering(request()->urutan, $query);
            }
    
            if (request()->filter) {
                $this->byFiltering(request()->filter, $query);
            }
    
            if (request()->limit) {
                $this->getAllActivitiesWithoutFilteringWithLimit(request()->limit, $query);
            }
    
            $activities = $query->get();
    
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
                    'made' => $madeBy,
                    'total_income' => $totalIncome,
                    'jumlah_volunteer' => $jumlahVolunteer,
                    'batas_waktu' => $selisihHari,
                    'foto_activity'=>$activity->foto_activity,
                    'status_publish' => $activity->status_publish,
                    'created_at'=> $activity->created_at,
                ];
            });
           
            return response()->json(['data' => $formattedData],200);
        } catch (HttpClientException $err) {
            return response()->json(['message' => $err->getMessage()], $err->getCode());
        }
    }
    public function show()
    {
        try {
            // Mendapatkan semua aktivitas, termasuk yang telah dihapus
            $activities = Activity::withTrashed()->get();
    
            // Mendapatkan tanggal saat ini
            $currentDate = now();
    
            // Menginisialisasi variabel untuk menyimpan jumlah aktivitas yang telah berakhir, termasuk yang telah dihapus, dan yang masih berlangsung
            $finishedActivitiesCount = 0;
            $ongoingActivitiesCount = 0;    
            // Melakukan iterasi pada setiap aktivitas untuk menghitung jumlah aktivitas yang telah berakhir dan yang masih berlangsung
            foreach ($activities as $activity) {
                // Jika aktivitas telah dihapus, tambahkan ke jumlah aktivitas yang telah berakhir
                if ($activity->deleted_at !== null) {
                    $finishedActivitiesCount++;
                    continue; // Lanjutkan ke aktivitas berikutnya
                }
    
                // Mendapatkan tanggal batas_waktu aktivitas
                $deadline = $activity->batas_waktu;
    
                // Memeriksa apakah tanggal batas_waktu lebih kecil dari tanggal saat ini, jika ya, maka aktivitas telah berakhir
                if ($deadline < $currentDate) {
                    $finishedActivitiesCount++;
                } else {
                    $ongoingActivitiesCount++;
                }
            }
    
            // Menyiapkan respons JSON
            $response = [
                'total' => $finishedActivitiesCount + $ongoingActivitiesCount,
                'finished' => $finishedActivitiesCount,
                'ongoing' => $ongoingActivitiesCount,
            ];
    
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function showPeserta($activity) {
        // Find the activity based on the slug
        $data_activity = Activity::where('id', $activity)->first();
    
        if (!$data_activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        $total_volunteer = $data_activity->donations()->where('status_donasi', 'Approved')->count();
    
        // Retrieve donations related to the activity using the relationship
        $total_donation = $data_activity->donations()
        ->where('status_donasi', 'Approved')
        ->sum('donasi');
        $donations = $data_activity->donations->toArray();
    
        // Format the donation data according to the specified schema
        $formattedDonations = array_map(function ($donation) {
            return [
                'id' => $donation['id'],
                'name' => $donation['nama'],
                'nominal' => (int) $donation['donasi'],
                'nomor_telp' => (int) $donation['nomor_telp'],
                'kode_donasi' => $donation['kode_donasi'],
                'date' => $donation['tanggal_donasi'],
                'status_donasi' => $donation['status_donasi'],
            ];
        }, $donations);
    
    
        return response()->json(['message' => 'success', 'total_donation' => $total_donation,'total_volunteer'=>$total_volunteer, 'data' => $formattedDonations
        ]);
    }
    
    

    
    
}
