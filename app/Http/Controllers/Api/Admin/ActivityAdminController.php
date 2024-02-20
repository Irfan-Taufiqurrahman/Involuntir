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
            
                return [
                    'id' => $activity->id,
                    'name' => $activity->judul_activity,
                    'price' => $priceValue,
                    'made' => $madeBy,
                    'total_income' => $totalIncome,
                    'jumlah_volunteer' => $jumlahVolunteer,
                    'batas_waktu' => $activity->batas_waktu,
                    'status_publish' => $activity->status_publish,
                ];
            });
           
            return response()->json(['data' => $formattedData],200);
        } catch (HttpClientException $err) {
            return response()->json(['message' => $err->getMessage()], $err->getCode());
        }
    }
    
    
}
