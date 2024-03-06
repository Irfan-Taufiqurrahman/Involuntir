<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityType;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Category;
use App\Models\ActivityPrice;
use App\Models\Criteria;
use App\Models\Donation;
use App\Models\Participation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task;
use App\Models\Voucher;
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

class ActivityController extends Controller
{
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
            'organisasi' => 'users.tipe = "organisasi"',
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
            if (request()->kategori) {
                $this->categoryFiltering(request()->kategori);
            }

            if (request()->urutan) {
                $this->orderByFiltering(request()->urutan);
            }

            if (request()->filter) {
                $this->byFiltering(request()->filter);
            }

            if (request()->limit) {
                $this->getAllActivitiesWithoutFilteringWithLimit(request()->limit);
            }

            $activities = $this->data ? $this->data : $this->getAllActivitiesWithoutFiltering();

            $joinWithRelatedTables = $activities->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')
                ->groupBy('activities.id')
                ->where('status_publish', 'published')
                ->orWhere('status_publish', null)
                ->with('prices')
                ->get([
                    'activities.id',
                    'judul_activity',
                    'judul_slug',
                    'foto_activity',
                    'batas_waktu',
                    'activities.created_at',
                    'jenis_activity',
                    'tipe_activity',
                    DB::raw("CONCAT(DATEDIFF(batas_waktu, CURRENT_DATE), ' hari') as sisa_waktu"),
                    DB::raw('COUNT(participations.id) as total_volunteer'),
                ]);

            return response()->json(['data' => $joinWithRelatedTables]);
        } catch (HttpClientException $err) {
            return response()->json(['message' => $err->getMessage()], $err->getCode());
        }
    }

    public function bySlug($activity)
    {
        $data_activity = Activity::where('judul_slug', $activity)->with('prices')->first();

        if (empty($data_activity)) {
            return response()->json(['message' => 'activity tidak ditemukan'], 404);
        }

        $id_activity = $data_activity->id;
        $id_activist = $data_activity->user_id;

        $activist = DB::table('users')
            ->where('id', $id_activist)
            ->get(['username', 'photo', 'name', 'status_akun', 'role', 'tipe', 'jenis_organisasi']);

         $total_volunteer = $data_activity->donations()->where('status_donasi', 'Approved')->count();

        // Fetch all vouchers related to the activity
        $vouchers = Voucher::whereHas('activity', function ($query) use ($id_activity) {
            $query->where('id', $id_activity);
        })->get();

        $tasks = Task::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get(DB::raw('tasks.id, tasks.deskripsi, tasks.created_at'));

        $criterias = Criteria::join('activities', 'activity_id', '=', 'activities.id')
            ->where('activity_id', $id_activity)
            ->get(DB::raw('criterias.id, criterias.deskripsi, criterias.created_at'));

        $user = auth('api')->user();

        $now = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
        $batas_waktu = Carbon::createFromFormat('Y-m-d H:s:i', $data_activity->batas_waktu);

        $data_activity->sisa_hari = $batas_waktu->diffInDays($now);

        // Check if user is logged in
        if ($user) {
            $user_donations = $user->total_donated;
            // dd($user_donations);exit();
            
            $vouchers = $vouchers->map(function ($voucher) use ($user_donations) {
                $minimumDonated = $voucher->minimum_donated;
    
                if ($user_donations >= $minimumDonated) {
                    // dd($user_donations);exit();

                    $voucher->status = 'available';
                } else {
                    $remainingDonations = $minimumDonated - $user_donations;
                    $message = "Maaf anda tidak bisa menggunakan voucher ini, lakukan aktivitas lagi sebanyak $remainingDonations kali, agar anda bisa klaim voucher ini.";
                    $voucher->message = $message;
                    $voucher->status = 'not available';
                }
    
                return $voucher;
            });
        }
    


        return response()->json([
            'data' => [
                'activity' => $data_activity,
                'user' => $activist,
                'total_volunteer' => $total_volunteer,
                // 'volunteer' => $total_volunteer,
                'vouchers' => $vouchers,
                'tugas' => $tasks,
                'kriteria' => $criterias,
                'is_mine' => $user ? ($user->id === $id_activist) : false,
            ],
        ]);
    }

    public function show(Activity $activity): JsonResponse
    {
        $activity = $activity->load([
            'prices', 'participants',
            'tasks',
            'criterias',
        ])->loadCount('participants');

        return response()->json([
            'data' => [
                'activity' => $activity,
            ],
        ]);
    }

    private function imageValidation(Request $request, $imageName)
    {
        $validator = Validator::make($request->all(), [
            $imageName => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);

        return $validator;
    }

    private function uploadImage(Request $request, $file, $judul_slug)
    {
        $fileName = $judul_slug . '.' . $request->file($file)->extension();
        $path = 'images/images_activity';
        $request->file($file)->move(public_path($path), $fileName);

        return env('APP_URL') . "/$path/$fileName";
    }

    public function publish(Request $request)
    {
        $request['status_publish'] = 'published';

        return $this->create($request);
    }

    public function draft(Request $request)
    {
        $request['status_publish'] = 'drafted';

        return $this->create($request);
    }

    public function create(Request $request)
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json(['message' => 'user not found!'], 404);
        }
        if (!$user || $user->tipe !== 'Organisasi') {
            return response()->json(['message' => 'Anda belum terdaftar sebagai organisasi'], 403);
        }
    
        $validator = Validator::make($request->all(), [
            'judul_activity' => 'required|string|max:255',
            'judul_slug' => 'sometimes|string|unique:activities,judul_slug|max:255',
            'category_id' => ['required', 'exists:categories,id'],
            'detail_activity' => 'required|string',
            'batas_waktu' => 'required',
            'foto_activity' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',          
            // 'foto_activity'=>'required|string',  
            'lokasi' => 'required|string|max:255',
            'waktu_activity' => 'required|string',
            'tipe_activity' => 'required|in:Virtual,In-Person,Hybrid',
            'kuota' => 'required|numeric',
            'tautan' => 'required|string',
            'link_guidebook'=>'string',
            'jenis_activity' => ['nullable', new Enum(ActivityType::class)],
            'biaya_activity' => ['required_if:jenis_activity,paid', 'array'],
            'biaya_activity.*.per' => ['required_if:jenis_activity,paid', 'numeric'],
            'biaya_activity.*.price' => ['required_if:jenis_activity,paid', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $validated = $validator->validated();

        $slug = ! empty($request->judul_slug) ? $validated['judul_slug'] : Str::slug($request->judul_activity . ' ' . Str::random(6));
        $photo = $request->file('foto_activity');
        $activityType = $request->jenis_activity ?? ActivityType::FREE->value;
        $activityPrices = $request->biaya_activity ?? [];

        if (! empty($photo)) {
            $photo = $this->uploadImage($request, 'foto_activity', $slug);
        }

        $activity = Activity::create([
            'category_id' => $validated['category_id'],
            'user_id' => $user->id,
            'judul_activity' => $request->judul_activity,
            'judul_slug' => $slug,
            'foto_activity' => $validated['foto_activity'],
            'detail_activity' => $request->detail_activity,
            'batas_waktu' => $request->waktu_activity,
            'waktu_activity' => $request->waktu_activity,
            'lokasi' => $request->lokasi,
            'tipe_activity' => $request->tipe_activity,
            'status_publish' => $request->status_publish,
            'status' => 'Pending',
            'kuota' => $request->kuota ? $request->kuota : 0,
            'link_wa' => $request->tautan ? $request->tautan : 'involuntir',
            'jenis_activity' => $activityType,
            'link_guidebook'=> $request->link_guidebook,
            'updated_at' => $request->status_publish === 'published' ? Carbon::now() : null,
        ]);

        // Create vouchers if present in the request
        if ($request->has('vouchers') && is_array($request->vouchers)) {
            $maxVouchers = min(count($request->vouchers), 5); // Batasi maksimal 5 jenis voucher
            for ($i = 0; $i < $maxVouchers; $i++) {
                $voucherData = $request->vouchers[$i];
                $voucher = Voucher::create([
                    'activity_id' => $activity->id,
                    'judul_slug_activity' => $activity->judul_slug,
                    'name_voucher' => $voucherData['name_voucher'],
                    'minimum_donated' => $voucherData['minimum_donated'],
                    'kuota_voucher' => $voucherData['kuota_voucher'],
                    'presentase_diskon' => $voucherData['presentase_diskon'],
                ]);
                // dd($voucher);exit();
            }
        }

        if (! empty($activityType) && ActivityType::PAID->equals(ActivityType::from($activityType))) {

            foreach ($activityPrices as $value) {
                $activity->prices()->updateOrCreate($value);
            }

            $activity->save();
        }

        $tasks = $request->tasks ? $request->tasks : "[]";

        foreach ($tasks as $task) {
            $task = Task::create([
                'activity_id' => $activity->id,
                'deskripsi' => $task,
            ]);
        }

        $activity->tasks = $tasks;

        $criterias = $request->criterias ? $request->criterias : "[]";
        foreach ($criterias as $criteria) {
            Criteria::create([
                'activity_id' => $activity->id,
                'deskripsi' => $criteria,
            ]);
        }

        $activity->criterias = $criterias;

        $activity->load('prices');

        return response()->json(['data' => $activity], 201);
    }


    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
    
        if (! $user) {
            return response()->json(['message' => 'User not found!'], 404);
        }
    
        $activity = Activity::find($id);
    
        if (empty($activity)) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
    
        // Otorisasi: Hanya pemilik aktivitas yang dapat mengubahnya
        if ($user->id !== intval($activity->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $validator = Validator::make($request->all(), [
            'judul_activity' => 'required|string|max:255',
            'judul_slug' => 'sometimes|string|unique:activities,judul_slug,'.$activity->id.'|max:255',
            'category_id' => ['required', 'exists:categories,id'],
            'detail_activity' => 'required|string',
            'batas_waktu' => 'required',
            'foto_activity' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lokasi' => 'required|string|max:255',
            'waktu_activity' => 'required|string',
            'tipe_activity' => 'required|in:Virtual,In-Person,Hybrid',
            'kuota' => 'required|numeric',
            'tautan' => 'required|string',
            'link_guidebook' => 'string',           
            'biaya_activity' => 'nullable|numeric', // Biaya harus numerik, tetapi bisa kosong // Setiap elemen dalam array harus numerik
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Proses upload gambar jika ada
        $validated = $validator->validated();
        $slug = ! empty($request->judul_slug) ? $validated['judul_slug'] : Str::slug($request->judul_activity . ' ' . Str::random(6));
        $photo = $request->file('foto_activity');
        

        if (! empty($photo)) {
            $photo = $this->uploadImage($request, 'foto_activity', $slug);
        }
    
        // Update aktivitas
        $activity->judul_activity = $request->judul_activity;
        $activity->judul_slug = $request->judul_slug;
        $activity->category_id = $request->category_id;
        $activity->detail_activity = $request->detail_activity;
        $activity->batas_waktu = $request->batas_waktu;
        $activity->lokasi = $request->lokasi;
        $activity->foto_activity = $photo;
        $activity->waktu_activity = $request->waktu_activity;
        $activity->tipe_activity = $request->tipe_activity;
        $activity->kuota = $request->kuota;
        $activity->link_wa = $request->tautan;
        $activity->link_guidebook = $request->link_guidebook;
    
        // Update vouchers if present in the request
        if ($request->has('vouchers') && is_array($request->vouchers)) {
            // Remove existing vouchers associated with the activity
            $activity->vouchers()->delete();

            // Create new vouchers from the request
            $maxVouchers = min(count($request->vouchers), 5); // Limit to 5 vouchers
            for ($i = 0; $i < $maxVouchers; $i++) {
                $voucherData = $request->vouchers[$i];
                Voucher::create([
                    'activity_id' => $activity->id,
                    'judul_slug_activity' => $activity->judul_slug,
                    'name_voucher' => $voucherData['name_voucher'],
                    'minimum_donated' => $voucherData['minimum_donated'],
                    'kuota_voucher' => $voucherData['kuota_voucher'],
                    'presentase_diskon' => $voucherData['presentase_diskon'],
                ]);
            }
        }

    

    

        // Simpan aktivitas yang telah diperbarui
        if (!empty($request->tasks)) {
            $tasks = json_decode($request->tasks);
        
            // Hapus semua tasks terkait dengan aktivitas
            $activity->tasks()->delete();
        
            // Tambahkan tasks yang baru
            foreach ($tasks as $task) {
                Task::create([
                    'activity_id' => $activity->id,
                    'deskripsi' => $task,
                ]);
            }
        
            // Muat ulang aktivitas dengan tasks yang baru
            $activity->load('tasks');
        }
        
        if (!empty($request->criterias)) {
            $criterias = json_decode($request->criterias);
        
            // Hapus semua criterias terkait dengan aktivitas
            $activity->criterias()->delete();
        
            // Tambahkan criterias yang baru
            foreach ($criterias as $criteria) {
                Criteria::create([
                    'activity_id' => $activity->id,
                    'deskripsi' => $criteria,
                ]);
            }
        
            // Muat ulang aktivitas dengan criterias yang baru
            $activity->load('criterias');
        }
        if (!empty($request->biaya_activity)) {
            $price = $request->biaya_activity;
            $activityPrice = ActivityPrice::updateOrCreate(
                ['activity_id' => $activity->id, 'per' => 1],
                ['price' => $price]
            );
        }
        
        $activity->save();
    
        return response()->json(['message' => 'Activity updated successfully', 'activity' => $activity]);
    }    

    private function getCategory(Category $category)
    {
        return Activity::orderBy('activities.created_at')
            ->where('category_id', $category->id)->leftJoin('participations', 'participations.activity_id', '=', 'activities.id')->groupBy('activities.id')->get(['activities.id', 'judul_activity', 'judul_slug', 'foto_activity', 'batas_waktu', 'activities.created_at', DB::raw('COUNT(participations.id) as total_volunteer')]);
    }

    public function isExist($slug)
    {
        return response()->json(['isExist' => Activity::where('judul_slug', $slug)->first() ? true : false]);
    }

    public function destroy(Activity $activity)
    {
        // old image is not deleted because this is a soft delete
        $activity->delete();

        return response()->json(['message' => 'berhasil menghapus activity'], 200);
    }

    public function myActivities()
    {
        $user = Auth::user();

        $activities = Activity::with('donations')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'judul_activity' => $activity->judul_activity,
                    'judul_slug' => $activity->judul_slug,
                    'foto_activity' => $activity->foto_activity,
                    'batas_waktu' => $activity->batas_waktu,
                    'created_at' => $activity->created_at,
                    'total_volunteer' => $activity->donations->where('status_donasi', 'Approved')->count(),
                ];
            });

        return ['data' => $activities];
    }
    
    public function showPeserta($activity) {
        // Find the activity based on the slug
        $data_activity = Activity::where('judul_slug', $activity)->first();
    
        if (!$data_activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        $total_volunteer = $data_activity->donations()->where('status_donasi', 'Approved')->count();

        // Retrieve donations related to the activity using the relationship
        $total_donation = $data_activity->donations()
        ->where('status_donasi', 'Approved')
        ->sum('donasi');
        $donations = $data_activity->donations;
    
        // Format the donation data according to the specified schema
        $formattedDonations = array_map(function ($donation) {
            return [
                'id' => $donation->id,
                'name' => $donation->nama,
                'nominal' => (int) $donation->donasi,
                'nomor_telp' => (int) $donation->nomor_telp,
                'kode_donasi' => $donation->kode_donasi,
                'date' => $donation->tanggal_donasi,
                'status_donasi' => $donation->status_donasi,
            ];
        }, $donations);

    
        return response()->json(['message' => 'success', 'total_donation' => $total_donation,'total_volunteer'=>$total_volunteer, 'data' => $formattedDonations
        ]);
    }
    public function endActivity(Request $request)
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json(['message' => 'user not found!'], 404);
        }
        $validator = Validator::make($request->all(), [
            'activity_id' => 'required|exists:activities,id',
            'batas_waktu' => 'sometimes|required',           
        ]);

        $validator->validate();

        $data_activity = Activity::find($request->activity_id);

        if ($request->has('batas_waktu')) {
            $data_activity->batas_waktu = $request->batas_waktu;
        }

        $data_activity->save();
        return response()->json(['message' => 'success']);
    }
    
}
